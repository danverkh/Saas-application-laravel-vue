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
            ->sortByDesc([
                'cpc',
                'current_rank',
                static function ($item) {
                    return Str::substrCount($item['url'] ?? '', '/');
                },
            ])
            ->toArray();

        return $next($items);
    }
}
