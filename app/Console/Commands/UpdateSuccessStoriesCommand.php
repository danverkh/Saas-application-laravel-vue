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
    protected $signature = 'update:success-stories {--limit=300}';

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
        $items = DB::connection('production')
                   ->table('autoranker_keywords_results')
                   ->groupBy(['client_id', 'autoranker_keyword_id'])
                   ->where('date', '>', now()->subMonths(2))
                   ->where('monthly_fee', '>', 0)
                   ->where('keyword_search_volume', '>', 0)
                   ->havingRaw('COUNT(*) > 5')
                   ->orderBy('date', 'DESC')
                   ->limit($this->option('limit'))
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
        $rankingCurve = [0, 0, 0, 5, 16, 24, 32, 41, 51, 65, 80, 88, 95, 97, 98, 99, 100];

        return $keywords->mapWithKeys(static function ($keywords, $keywordId) use ($rankingCurve, $ctr) {
            // ranking
            $ranking    = collect($keywords)->pluck('ranking');
            $maxRanking = collect($ranking)->max();

            $ranking = $ranking->map(static function ($value, $index) use ($rankingCurve, $maxRanking) {
                $rankingCurveValue = $rankingCurve[$index] ?? random_int(99, 100);

                if ($rankingCurveValue === 0) {
                    return 0;
                }
                $value = ($maxRanking - $value) / $maxRanking * 100;

                $result = $value > $rankingCurveValue
                    ? $rankingCurveValue + $value / 6
                    : $rankingCurveValue - $value / 6;

                return max(min(round($result, 1), 100), 0);
            })->toArray();

            $moveCount = random_int(0, 3);
            if ($moveCount > 0) {
                for ($i = 0; $i <= $moveCount; $i++) {
                    array_unshift($ranking, 0);
                    array_pop($ranking);
                }
            }

            // traffic value
            $trafficValueCurve = [0, 0, 0, 0, 0, 0, 2, 5, 8, 12, 18, 26, 35, 52, 75, 98, 105, 106];

            $trafficValue    = collect($keywords)->map(static function ($keywords) use ($ctr) {
                // monthly search volume/30 * cpc * ctr at rank
                return ($keywords->keyword_search_volume / 30) * $keywords->keyword_cpc * $ctr;
            });
            $maxTrafficValue = collect($trafficValue)->max();

            $trafficValue = collect($trafficValue)->map(static fn($i) => $i / $maxTrafficValue * 100);

            $trafficValue = $trafficValue->map(static function ($value, $index) use ($trafficValueCurve) {
                $trafficValue = $trafficValueCurve[$index] ?? 106;

                if ($trafficValue === 0) {
                    return 0;
                }
                $value = randomFloat(0, $index < 23 ? 10 : 2);

                $result = $value > $trafficValue
                    ? $trafficValue + $value
                    : $trafficValue - $value;

                return max(min(round($result, 1), 106), 0);
            })->toArray();

            $moveCount = random_int(0, 3);
            if ($moveCount > 0) {
                for ($i = 0; $i <= $moveCount; $i++) {
                    array_unshift($trafficValue, 0);
                    array_pop($trafficValue);
                }
            }

            return [
                $keywordId => [
                    'ranking'      => $ranking,
                    'trafficValue' => $trafficValue,
                ],
            ];
        })->toArray();
    }
}
