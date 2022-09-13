<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;
use Illuminate\Support\Str;

class Limit
{
    /**
     * @param array    $items
     * @param \Closure $next
     * @param int      $limit
     *
     * @return mixed
     */
    public function handle(array $items, Closure $next, int $limit)
    {
        if (count($items) > $limit) {
            $items = array_splice($items, 0, $limit);
        }

        return $next($items);
    }
}
