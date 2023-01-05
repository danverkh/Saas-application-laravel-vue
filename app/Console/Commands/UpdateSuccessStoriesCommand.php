<?php

namespace App\Console\Commands;

use App\Models\SuccessStory;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UpdateSuccessStoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:success-stories';

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
        $items = Cache::rememberForever('temp', static function () {
            return DB::connection('production')
                     ->table('autoranker_keywords_results')
                     ->groupBy(['client_id', 'autoranker_keyword_id'])
                     ->where('date', '>', now()->subMonths(2))
                     ->havingRaw('COUNT(*) > 5')
                     ->orderBy('date', 'DESC')
                     ->limit(5)
                     ->get();
        });

        $new = [];

        $this->info('Fetched items: ' . $items->count());

        $items->groupBy('client_id')
              ->chunk(50)
              ->each(function (Collection $chunk) use (&$new) {
                  $chunk->each(function ($items, $clientId) use (&$new) {
                      $this->line('-----------------------------');
                      $this->info('Fetching keywords for client ' . $clientId);
                      $firstRow = $items->first();

                      $keywordsData = DB::connection('production')
                                        ->table('autoranker_keywords_results')
                                        ->select([
                                            'client_id', 'autoranker_keyword_id', 'date',
                                            'ranking', 'keyword_search_volume', 'keyword_cpc',
                                        ])
                                        ->whereIn('autoranker_keyword_id', $items->pluck('autoranker_keyword_id'))
                                        ->where('date', '>', now()->subMonths(2))
                                        ->get();

                      $this->info("Got {$keywordsData->count()} keyword rows");

                      SuccessStory::updateOrCreate(
                          [
                              'client_id' => $clientId,
                          ],
                          [
                              'client_industry' => $firstRow->client_industry,
                              'client_country'  => $firstRow->client_country,
                              'client_city'     => $firstRow->client_city,
                              'monthly_fee'     => $firstRow->monthly_fee,
                              'keywords'        => $keywordsData
                                  ->groupBy('autoranker_keyword_id')
                                  ->each(static function ($groupItems) {
                                      $groupItems
                                          ->map(static function ($item) {
                                              $item->timestamp = Carbon::parse($item->date)->timestamp;
                                              return $item;
                                          })
                                          ->sortBy('timestamp')
                                          ->map(static function ($item) {
                                              unset($item->client_id, $item->autoranker_keyword_id, $item->timestamp);
                                              return $item;
                                          });
                                  }),
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
