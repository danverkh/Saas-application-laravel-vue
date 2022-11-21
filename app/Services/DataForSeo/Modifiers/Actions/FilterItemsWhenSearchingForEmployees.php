<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;
use Illuminate\Support\Str;

class FilterItemsWhenSearchingForEmployees
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
            ->filter(static fn ($item) => Str::contains($item['keyword'], ['job', 'career', 'salary']))
            ->values()
            ->toArray();

        return $next($items);
    }
}
