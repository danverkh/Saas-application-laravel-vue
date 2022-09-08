<?php

namespace App\Services;

use App\Services\DataForSeo\Params;
use App\Services\DataForSeo\Request;
use Illuminate\Support\Str;

class DataForSeoService
{
    private string $url = 'https://api.dataforseo.com/';

    /**
     * @var array|mixed|string|string[]|null
     */
    private $result;

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
    public function fetch(string $query, string $market, int $limit = 500): self
    {
        $market = Str::upper($market);

        $request = new Request($query, $market, $limit);

        $this->result = $request->fetch()->result();

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return data_get($this->result, 'tasks.0.result.0.items', []) ?? [];
    }
}
