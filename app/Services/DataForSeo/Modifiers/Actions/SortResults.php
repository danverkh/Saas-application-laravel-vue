<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use App\Services\Domain;
use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SortResults
{
    /**
     * @param             $items
     * @param \Closure    $next
     * @param string      $domain
     * @param string|null $assistant
     *
     * @return mixed
     */
    public function handle($items, Closure $next, string $domain, string|null $assistant = null)
    {
        // default and when assistant is set to conversions
        $mainSort = ['cpc', 'desc'];

        if ($assistant === 'branding') {
            $mainSort = ['search_volume', 'desc'];
        }

        //$relevantWords = Domain::getRelevantWordsFromDescription($domain);

        $items = collect($items)
            ->sortBy([
                ['relevance', 'desc'],
                $mainSort,
                [static fn ($item) => Str::substrCount($item['url'] ?? '', '/'), 'desc'],
                //[static fn ($item) => Str::contains($item['keyword'], $relevantWords, true), 'desc'],
            ])
            ->values()
            ->toArray();

        return $next($items);
    }
}
