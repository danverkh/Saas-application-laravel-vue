<?php

namespace App\Services\DataForSeo\Modifiers;

use Closure;
use Illuminate\Support\Str;

class SortResults
{
    /**
     * @param          $items
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($items, Closure $next)
    {
        $items = collect($items)
            ->sortBy([
                ['cpc', 'desc'],
                ['current_rank', 'desc'],
                [static fn ($item) => Str::substrCount($item['url'] ?? '', '/'), 'desc'],
            ])
            ->values()
            ->toArray();

        return $next($items);
    }
}
