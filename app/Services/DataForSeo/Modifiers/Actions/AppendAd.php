<?php

namespace App\Services\DataForSeo\Modifiers\Actions;

use Closure;
use Illuminate\Support\Str;

class AppendAd
{
    /**
     * @param array    $items
     * @param \Closure $next
     * @param bool     $hasPaidAds
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle(array $items, Closure $next, bool $hasPaidAds)
    {
        if ($hasPaidAds) {
            array_unshift($items, [
                'type'        => 'ad',
                'title'       => $this->getText(30),
                'description' => $this->getText(50),
            ]);
        }

        return $next($items);
    }

    /**
     * @param int $min
     *
     * @return string
     * @throws \Exception
     */
    private function getText(int $min): string
    {
        $text = '';

        do {
            $text .= ' '. fake()->sentence(random_int(3, 8));
        } while (strlen($text) < $min);

        return trim($text);
    }
}
