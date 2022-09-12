<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;

class CalculateMissingValues
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
            ->map(static function ($item) {
                $cpc = (float) ($item['cpc'] ?? 0.52);
                $searchVolume = (float) $item['search_volume'] ?? 10;

                return array_merge($item, [
                    'projected_clicks'  => round($searchVolume * 0.18, 2),
                    'projected_traffic' => round($searchVolume * $cpc * 0.18, 2),
                    'maximum_cost'      => round($searchVolume * $cpc * 0.18 * 0.3, 2),
                ]);
            })
            ->toArray();

        return $next($items);
    }
}
