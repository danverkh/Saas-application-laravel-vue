<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Language;
use DOMDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Domain
{
    /**
     * @param        $languageOrCountryCode
     * @param string $domain
     *
     * @return string|null
     */
    public static function getMarket($languageOrCountryCode, string $domain): ?string
    {
        if (!is_string($languageOrCountryCode)) {
            return null;
        }

        $code = Str::of($languageOrCountryCode)->upper()->trim();

        // try to find by language
        $language = Language::where('code', $code)->with('countries')->first();
        $country  = collect(data_get($language, 'countries', []))->firstWhere('iso2', $code);
        $market   = $country?->iso2;

        if ($market) {
            return Str::lower($market);
        }

        // check if it is already a country code
        $country = Country::where('iso2', $code)->first();

        if ($country) {
            return Str::lower($code);
        }

        // get country code from TLD
        $tld = (string)Str::of($domain)->afterLast('.');

        $country = Country::where('tld', $tld)->first();

        if ($country) {
            return Str::lower($country->iso2);
        }

        return null;
    }

    /**
     * @param string $domain
     *
     * @return array
     */
    public static function getRelevantWordsFromTitleAndDescription(string $domain): array
    {
        $pageBody = self::getPageBody($domain);

        $dom = new DOMDocument();
        @$dom->loadHTML($pageBody);
        $nodes = $dom->getElementsByTagName('title');
        $text  = $nodes->item(0)->nodeValue;

        $nodes = $dom->getElementsByTagName('meta');
        $node = collect($nodes)->first(static fn($node) => $node->getAttribute('name') === 'description');
        $text .= $node ? ' ' . $node->getAttribute('content') : '';

        $text = Str::lower($text);

        return collect(explode(' ', $text))
            ->map(static fn($word) => preg_replace('/[[:punct:]]/', '', $word)) // remove punctuations
            ->reject(static fn($word) => strlen($word) < 4) // reject words that have less than 4 letters
            ->values()
            ->toArray();
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getPageBody(string $url): string
    {
        return Cache::remember("page_content.{$url}", now()->addHour(), static function () use ($url) {
            return Http::get($url)->body();
        });
    }
}
