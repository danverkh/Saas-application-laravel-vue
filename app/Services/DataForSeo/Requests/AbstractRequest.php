<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Params;
use App\Services\RestClient;

abstract class AbstractRequest
{
    protected ?Params $params;

    protected RestClient $client;

    protected array $result;

    /**
     * @param \App\Services\DataForSeo\Params|null $params
     */
    public function __construct(?Params $params = null)
    {
        $this->params = $params;

        $user = config('services.dataforseo.user');
        $password = config('services.dataforseo.password');

        $this->client = new RestClient('https://api.dataforseo.com/', null, $user, $password);
    }

    abstract public function fetch(): array;

    /**
     * @param \App\Services\DataForSeo\Params $params
     *
     * @return void
     */
    public function setParams(Params $params): void
    {
        $this->params = $params;
    }
}
