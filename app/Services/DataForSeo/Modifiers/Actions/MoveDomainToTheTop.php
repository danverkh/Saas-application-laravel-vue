<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;
use Illuminate\Support\Str;

class MoveDomainToTheTop
{
    /**
     * @param array    $items
     * @param \Closure $next
     * @param string   $domain
     *
     * @return mixed
     */
    public function handle(array $items, Closure $next, string $domain)
    {
        $items = collect($items)
            ->sortByDesc(static function ($item) use ($domain) {
                return Str::contains($item['url'], $domain) ? 1 : 0;
            })
            ->values()
            ->toArray();

        return $next($items);
    }
}
