<?php

namespace App\Services;

class DataForSeoService
{
    private string $url = 'https://api.dataforseo.com/';

    private RestClient $client;

    /**
     * Init rest client in constructor
     */
    public function __construct()
    {
        $user     = config('services.dataforseo.user');
        $password = config('services.dataforseo.password');

        $this->client = new RestClient($this->url, null, $user, $password);
    }

    /**
     * @param string $keyword
     * @param string $market
     *
     * @return array|null
     */
    public function fetch(string $keyword, string $market): array|null
    {
        $marketDetails = $this->getLocationAndLanguageForMarket($market);

        $data = [
            "target"        => idn_host_to_ascii($domain),
            'location_name' => $languageByLocation[$market]['location'],
            'language_name' => $languageByLocation[$market]['language'],
            "limit"         => $prefilter_fs,
            "filters"       => [
                ["ranked_serp_element.serp_item.rank_group", ">", 1],
                "and",
                ["ranked_serp_element.serp_item.rank_group", "<", 70],
            ],
            //[
            //    'location_name' => $marketDetails['location'],
            //    'language_name' => $marketDetails['language'],
            //    'keyword'       => mb_convert_encoding($keyword, 'UTF-8'),
            //],
        ];

        /v3/dataforseo_labs/ranked_keywords/live
        return $this->client->post('/v3/serp/google/organic/live/regular', $data);
    }

    /**
     * @param string $market
     *
     * @return string[]
     */
    protected function getLocationAndLanguageForMarket(string $market): array
    {
        return [
           'AT' => ['location' => 'Austria', 'language' => 'German'],
           'BE' => ['location' => 'Belgium', 'language' => 'French'],
           'CH' => ['location' => 'Switzerland', 'language' => 'German'],
           'DE' => ['location' => 'Germany', 'language' => 'German'],
           'FR' => ['location' => 'France', 'language' => 'French'],
           'IT' => ['location' => 'Italy', 'language' => 'Italian'],
           'ES' => ['location' => 'Spain', 'language' => 'Spanish'],
           'UK' => ['location' => 'United Kingdom', 'language' => 'English'],
       ][$market];
    }
}
