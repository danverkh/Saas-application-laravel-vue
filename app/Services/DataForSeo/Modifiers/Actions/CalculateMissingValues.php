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
            ->map(static fn($item) => array_merge($item, self::calculate($item)))
            ->toArray();

        return $next($items);
    }

    /**
     * @param array $item
     *
     * @return array
     */
    public static function calculate(array $item): array
    {
        $cpc          = (float) ($item['cpc'] ?? 0.52);
        $searchVolume = (float) ($item['search_volume'] ?? 10);

        return [
            'projected_clicks'  => round($searchVolume * 0.18, 2),
            'projected_traffic' => round($searchVolume * $cpc * 0.18, 2),
            'maximum_cost'      => round($searchVolume * $cpc * 0.18 * 0.3, 2),
        ];
    }
}
