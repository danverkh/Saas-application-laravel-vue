<?php

namespace App\Services;

use App\Services\DataForSeo\Request;
use Illuminate\Support\Str;

class DataForSeoService
{
    /**
     * @var string
     */
    private string $requestType;

    /**
     * @param String $request
     *
     * @return $this
     */
    public function setRequestType(String $request): self
    {
        $this->requestType = $request;

        return $this;
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

        $request = new Request($this->requestType, $query, $market, $limit);

        return $request->fetch()->result();
    }
}
