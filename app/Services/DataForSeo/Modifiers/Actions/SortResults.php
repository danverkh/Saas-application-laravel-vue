<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;
use Illuminate\Support\Str;

class SortResults
{
    /**
     * @param             $items
     * @param \Closure    $next
     * @param string|null $assistant
     *
     * @return mixed
     */
    public function handle($items, Closure $next, ?string $assistant)
    {
        // default and when assistant is set to conversions
        $mainSort = ['cpc', 'desc'];

        if ($assistant === 'branding') {
            $mainSort = ['search_volume', 'desc'];
        }

        $items = collect($items)
            ->sortBy([
                $mainSort,
                ['current_rank', 'desc'],
                [static fn ($item) => Str::substrCount($item['url'] ?? '', '/'), 'desc'],
            ])
            ->values()
            ->toArray();

        return $next($items);
    }
}
