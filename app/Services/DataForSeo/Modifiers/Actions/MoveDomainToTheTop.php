<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;

class MoveDomainToTheTop
{
    /**
     * @param          $items
     * @param string   $domain
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($items, string $domain, Closure $next)
    {
        $items = collect($items)
            ->sortBy(function () {

            })
            ->toArray();

        return $next($items);
    }
}
