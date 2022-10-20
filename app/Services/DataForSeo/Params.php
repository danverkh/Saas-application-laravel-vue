<?php

namespace App\Services\DataForSeo;

use App\Models\Country;
use Illuminate\Support\Str;

class Params
{
    public string $query;
    public string $market;
    public int    $limit;

    /**
     * @var \App\Models\Country
     */
    public Country $country;

    /**
     * @param string $query
     * @param string $market
     * @param int    $limit
     */
    public function __construct(string $query, string $market, int $limit)
    {
        $this->query  = $query;
        $this->market = Str::upper($market);
        $this->limit  = $limit;

        $this->country = Country::where('iso2', $this->market)
                                ->orWhere('tld', $this->market)
                                ->first();
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->country->name ?? 'United Kingdom';
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->country->languages->first()->name ?? 'English';
    }
}
