<?php

namespace App\Services;

use Illuminate\Support\Str;

class DataForSeoService
{
    private string $url = 'https://api.dataforseo.com/';

    private RestClient $client;

    /**
     * @var array|mixed|string|string[]|null
     */
    private $result;

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
     * @param string $query
     * @param string $market
     * @param int    $limit
     *
     * @return \App\Services\DataForSeoService
     */
    public function fetch(string $query, string $market, int $limit = 10): self
    {
        $market = Str::upper($market);

        $data = [
            [
                'target'        => $this->idn_host_to_ascii($query),
                'location_name' => $this->languageByLocation[$market]['location'],
                'language_name' => $this->languageByLocation[$market]['language'],
                'limit'         => $limit,
                'filters'       => [
                    ['ranked_serp_element.serp_item.rank_group', '>', 1],
                    'and',
                    ['ranked_serp_element.serp_item.rank_group', '<', 70],
                ],
            ],
        ];

        $this->result = $this->client->post('/v3/dataforseo_labs/ranked_keywords/live', $data);

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return data_get($this->result, 'tasks.0.result.0.items', []);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function idn_host_to_ascii(string $url): string
    {
        $urlArray = parse_url($url);

        // no scheme available? e.g. just "demouser.de" => add scheme
        if (!\array_key_exists('scheme', $urlArray)) {
            $urlArray = parse_url('http://' . $url);
        }

        if ($urlArray === false) {
            return $url;
        }

        if (!\array_key_exists('host', $urlArray)) {
            return $url;
        }

        $originalHost = $urlArray['host'];
        $asciiHost    = \idn_to_ascii($originalHost, 0, \INTL_IDNA_VARIANT_UTS46);

        if ($asciiHost === false) {
            return $url;
        }

        return \str_replace($originalHost, $asciiHost, $url);
    }
}
