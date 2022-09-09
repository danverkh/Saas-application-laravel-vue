<?php

namespace App\Services\DataForSeo\Modifiers;

use Closure;

class UniqueKeywords
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
            ->unique('keyword')
            ->toArray();

        return $next($items);
    }
}
