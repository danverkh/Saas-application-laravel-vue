<?php

namespace App\Console\Commands;

use App\Jobs\FetchDomainKeywordRankJob;
use App\Models\Keyword;
use Illuminate\Console\Command;

class QueueFetchDomainKeywordsRankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:fetch-domain-keywords-rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue fetch domain bought keywords rank jobs';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $keywords = Keyword::whereNull('termination_date')
                           ->whereDoesntHave('rankings', function ($query) {
                               $query->whereDate('created_at', today());
                           })
                           ->select(['id', 'keyword', 'domain', 'country'])
                           ->get();

        foreach ($keywords as $keyword) {
            FetchDomainKeywordRankJob::dispatch($keyword)
                                     ->onQueue(FetchDomainKeywordRankJob::QUEUE);
        }

        $this->info('Queued ' . count($keywords) . ' jobs');
    }
}
