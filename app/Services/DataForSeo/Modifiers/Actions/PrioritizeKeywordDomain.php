<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;
use Utopia\Domains\Domain;

class PrioritizeKeywordDomain
{
    /**
     * @param array    $items
     * @param \Closure $next
     * @param string   $keywords
     *
     * @return mixed
     */
    public function handle(array $items, Closure $next, string $keywords)
    {
        $keywordHasDomain = collect($items)
            ->reject(static fn ($item) => !isset($item['url']))
            ->filter(static function ($item) use ($keywords) {
                try {
                    //dump($keywords .' - '.$item['url']. ' = ' . (new Domain($item['url']))->getName());
                    return str_contains($keywords, (new Domain($item['url']))->getName());
                } catch (Exception $e) {
                    Log::warning('Failed to parse url', ['url' => $item['url'], 'message' => $e->getMessage()]);
                    return false;
                }
            })
            ->isNotEmpty();

        if ($keywordHasDomain) {
            // switch first and second
            $temp     = $items[1];
            $items[1] = $items[0];
            $items[0] = $temp;
            unset($temp);
        }

        return $next($items);
    }
}
