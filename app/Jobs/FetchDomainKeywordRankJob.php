<?php

namespace App\Jobs;

use App\Models\Keyword;
use App\Services\DataForSeo\Request as DataForSeoRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class FetchDomainKeywordRankJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const QUEUE = 'fetch-domain-keyword-rank';

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * @var \App\Models\Keyword
     */
    private Keyword $keyword;

    /**
     * Create a new job instance.
     */
    public function __construct(Keyword $keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = app()->make(DataForSeoRequest::class);

        $items = $client->request(DataForSeoRequest::GOOGLE_KEYWORD_REGULAR)
                        ->params(['keyword' => $this->keyword->keyword, 'max_crawl_pages' => 2, 'depth' => 30], $this->keyword->country)
                        ->fetch()
                        ->rawItems();

        $found = collect($items)->first(function ($item) {
            return $item['domain'] === $this->keyword->domain || Str::contains($item['domain'], $this->keyword->domain, true);
        });

        $this->keyword->rankings()->create([
            'rank'       => $found ? $found['rank_absolute'] : 30,
            'created_at' => now(),
        ]);
    }
}
