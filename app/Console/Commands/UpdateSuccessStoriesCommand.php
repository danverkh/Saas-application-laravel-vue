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
        $items = DB::connection('production')
                   ->table('autoranker_keywords_results')
                   ->groupBy(['client_id', 'autoranker_keyword_id'])
                   ->where('date', '>', now()->subMonths(2))
                   ->havingRaw('COUNT(*) > 5')
                   ->orderBy('date', 'DESC')
                   ->limit(20)
                   ->get();

        $new = [];

        $items->chunk(50)
              ->each(static function (Collection $chunk) use (&$new) {
                  $keywordIds = $chunk->pluck('autoranker_keyword_id');

                  $keywordsData = DB::connection('production')
                                    ->table('autoranker_keywords_results')
                                    ->select([
                                        'client_id', 'autoranker_keyword_id', 'date',
                                        'ranking', 'keyword_search_volume', 'keyword_cpc',
                                    ])
                                    ->whereIn('autoranker_keyword_id', $keywordIds)
                                    ->where('date', '>', now()->subMonths(2))
                                    ->get();

                  $chunk->each(static function ($row) use ($keywordsData, &$new) {
                      $groupedKeywords = $keywordsData
                          ->where('client_id', $row->client_id)
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
                          });

                      SuccessStory::updateOrCreate(
                          [
                              'client_id' => $row->client_id,
                          ],
                          [
                              'client_industry' => $row->client_industry,
                              'client_country'  => $row->client_country,
                              'client_city'     => $row->client_city,
                              'monthly_fee'     => $row->monthly_fee,
                              'keywords'        => $groupedKeywords->toArray(),
                          ]
                      );

                      $new[] = $row->client_id;
                  });
              });

        if (count($new)) {
            SuccessStory::whereNotIn('client_id', $new)->delete();
        }

        return Command::SUCCESS;
    }
}
