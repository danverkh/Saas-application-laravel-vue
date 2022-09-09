<?php

namespace App\Services;

use App\Services\DataForSeo\Request;
use Illuminate\Support\Str;

class DataForSeoService
{
    private string $url = 'https://api.dataforseo.com/';

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
     * @return array
     */
    public function fetch(string $query, string $market, int $limit = 500): array
    {
        $market = Str::upper($market);

        $request = new Request($query, $market, $limit);

        return $request->fetch()->result();
    }
}
