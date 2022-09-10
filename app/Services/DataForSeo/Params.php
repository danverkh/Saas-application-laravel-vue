<?php

namespace App\Services\DataForSeo;

class Params
{
    private $languageByLocation = [
        'AT' => ['location' => 'Austria', 'language' => 'German'],
        'BE' => ['location' => 'Belgium', 'language' => 'French'],
        'CH' => ['location' => 'Switzerland', 'language' => 'German'],
        'DE' => ['location' => 'Germany', 'language' => 'German'],
        'FR' => ['location' => 'France', 'language' => 'French'],
        'IT' => ['location' => 'Italy', 'language' => 'Italian'],
        'ES' => ['location' => 'Spain', 'language' => 'Spanish'],
        'UK' => ['location' => 'United Kingdom', 'language' => 'English'],
        'US' => ['location' => 'United States', 'language' => 'English'],
    ];

    public string $query;
    public string $market;
    public int    $limit;

    /**
     * @param string $query
     * @param string $market
     * @param int    $limit
     */
    public function __construct(string $query, string $market, int $limit)
    {
        $this->query  = $query;
        $this->market = $market;
        $this->limit  = $limit;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return data_get($this->languageByLocation[$this->market], 'location');
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return data_get($this->languageByLocation[$this->market], 'language');
    }
}
