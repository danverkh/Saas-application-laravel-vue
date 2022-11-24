<?php

namespace App\Services\DataForSeo;

use App\Models\Country;
use Illuminate\Support\Str;

class Params
{
    public array  $params;
    public string $market;
    public int    $limit;

    /**
     * @var \App\Models\Country
     */
    public Country $country;

    /**
     * @param array  $params
     * @param string $market
     * @param int    $limit
     */
    public function __construct(array $params, string $market, int $limit)
    {
        $this->params = $params;
        $this->market = Str::upper($market);
        $this->limit  = $limit;

        $this->country = Country::where('iso2', $this->market)
                                ->orWhere('tld', $this->market)
                                ->first();
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->params[$key] ?? null;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->params;
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
