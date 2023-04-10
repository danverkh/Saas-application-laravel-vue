<?php

namespace App\Console\Commands;

use App\Models\SuccessStory;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class UpdateSuccessStoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:success-stories {--limit=1500}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will pull and parse success stories and save to the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rowsLimit = min($this->option('limit'), 50);
        $count = ceil($this->option('limit') / $rowsLimit);

        for ($i = 0; $i < $count; $i++) {

            $items = DB::connection('production')
                       ->table('autoranker_keywords_results')
                       ->groupBy(['client_id', 'autoranker_keyword_id'])
                       ->where('date', '>', now()->subMonths(2))
                       ->where('monthly_fee', '>', 0)
                       ->where('keyword_search_volume', '>', 0)
                       ->havingRaw('COUNT(*) > 5')
                       ->orderBy('date', 'DESC')
                       ->limit($rowsLimit)
                       ->offset($i * $rowsLimit)
                       ->get();

            $new = [];

            $this->info('Fetched items: ' . $items->count());

            $items->groupBy('client_id')
                  ->chunk(50)
                  ->each(function (Collection $chunk) use (&$new) {
                      $chunk->each(function ($items, $clientId) use (&$new) {
                          $this->line('-----------------------------');
                          $this->info('Fetching keywords for client ' . $clientId);
                          $firstRow = $items->first();

                          $keywordsData = collect([]);

                          $items->pluck('autoranker_keyword_id')
                                ->each(function ($keywordId) use (&$keywordsData) {
                                    $this->info('Fetching keyword: ' . $keywordId);

                                    $items = DB::connection('production')
                                               ->table('autoranker_keywords_results')
                                               ->select([
                                                   'client_id', 'autoranker_keyword_id', 'date',
                                                   'ranking', 'keyword_search_volume', 'keyword_cpc',
                                               ])
                                               ->where('autoranker_keyword_id', $keywordId)
                                               ->where('monthly_fee', '>', 0)
                                               ->where('keyword_search_volume', '>', 0)
                                               ->orderBy('date')
                                               ->get();

                                    $keywordsData = $keywordsData->concat($items->toArray());
                                });

                          $this->info("Got {$keywordsData->count()} keyword rows");

                          $firstTimestamp = null;

                          $keywords = $keywordsData
                              ->groupBy('autoranker_keyword_id')
                              ->each(static function ($groupItems) use (&$firstTimestamp) {
                                  $groupItems
                                      ->map(static function ($item) {
                                          $item->timestamp = Carbon::parse($item->date)->timestamp;
                                          return $item;
                                      })
                                      ->sortBy('timestamp')
                                      ->tap(static function ($items) use (&$firstTimestamp) {
                                          if ($items[0]->timestamp < $firstTimestamp || $firstTimestamp === null) {
                                              $firstTimestamp = $items[0]->timestamp;
                                          }
                                      })
                                      ->map(static function ($item) {
                                          unset($item->client_id, $item->autoranker_keyword_id, $item->timestamp);
                                          return $item;
                                      });
                              });

                          SuccessStory::updateOrCreate(
                              [
                                  'client_id' => $clientId,
                              ],
                              [
                                  'client_industry'       => $firstRow->client_industry,
                                  'client_country'        => $firstRow->client_country,
                                  'client_city'           => $firstRow->client_city,
                                  'monthly_fee'           => $firstRow->monthly_fee,
                                  'campaign_active_since' => Carbon::createFromTimestamp($firstTimestamp)->toDateString(),
                                  'ctr'                   => $ctr = randomFloat(0.40, 0.55),
                                  'keywords'              => $keywords,
                                  'chart'                 => $this->getChartData($keywords, $ctr),
                              ]
                          );

                          $this->info("Saved client {$clientId}");

                          $new[] = $clientId;
                      });
                  });
        }

        if (count($new)) {
            SuccessStory::whereNotIn('client_id', $new)->delete();
            $this->info('Removed old clients');
        }

        $this->info('Finished');

        return Command::SUCCESS;
    }

    /**
     * @param \Illuminate\Support\Collection $keywords
     * @param float                          $ctr
     *
     * @return array
     * @throws \Exception
     */
    private function getChartData(Collection $keywords, float $ctr): array
    {
        // ranking
        $rankingCurve = [100, 99, 98, 97, 95, 88, 80, 65, 51, 41, 32, 24, 16, 5];

        return $keywords->mapWithKeys(static function ($keywords, $keywordId) use ($rankingCurve, $ctr) {
            // ranking
            $ranking = collect($keywords)->pluck('ranking');

            $ranking->transform(static function ($value, $index) use ($rankingCurve, $ranking) {
                if ($index > count($rankingCurve)) {
                    if (random_int(1, 100) < 85) {
                        return 1;
                    }
                    if (random_int(1, 100) < 90) {
                        return 2;
                    }
                    return 3;
                }

                $rankingCurveValue = $rankingCurve[$index] ?? random_int(1, 2);

                $result = $value;

                // limit difference from previous value
                if ($index > 0 && $ranking[$index - 1] < $result) {
                    $result = $ranking[$index - 1] + random_int(-1, 3);
                }

                if (!isBetween($result, $rankingCurveValue - 5, $rankingCurveValue + 3, true)) {
                    $result = $result > ($rankingCurveValue + 2)
                        ? $result - random_int(1, 3)
                        : $result + random_int(1, 3);
                }

                return $result;
            });

            $ranking = $ranking->toArray();

            // traffic value
            $trafficValueCurve = [1, 5, 9, 19, 15, 20, 32, 35, 31, 51, 55, 47, 60, 75, 80, 88, 70, 72, 69, 78, 95, 97, 98, 99, 100];

            $trafficValue = collect($keywords)->map(static function ($keywords, $index) use ($ctr, $trafficValueCurve) {
                // monthly search volume/30 * cpc * ctr at rank
                $value = ($keywords->keyword_search_volume / 30) * $keywords->keyword_cpc * $ctr;

                return $value * (($trafficValueCurve[$index] ?? last($trafficValueCurve))/100);
            });

            $trafficValue = $trafficValue->map(static function ($value) {
                $result = $value - random_int($value/15 * -1, $value/15);

                return round($result, 1);
            })->toArray();

            return [
                $keywordId => [
                    'ranking'      => $ranking,
                    'trafficValue' => $trafficValue,
                ],
            ];
        })->toArray();
    }
}
