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
    protected $signature = 'update:success-stories {--limit=200}';

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
                                           ->limit(30)
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
                              'ctr'                   => randomFloat(0.40, 0.55),
                              'keywords'              => $keywords,
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
}
