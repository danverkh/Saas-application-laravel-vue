<?php

namespace App\Services\DataForSeo;

use App\Services\DataForSeo\Requests\DomainSearch;
use App\Services\DataForSeo\Requests\KeywordList;
use App\Services\DataForSeo\Requests\AbstractRequest;
use App\Services\DataForSeo\Requests\SingleKeyword;

class Request
{
    /**
     * @var \App\Services\DataForSeo\Params
     */
    private Params $params;

    /**
     * @var array
     */
    private array $result;

    /**
     * @param string $query
     * @param string $market
     * @param int    $limit
     */
    public function __construct(string $query, string $market, int $limit)
    {
        $this->params = new Params($query, $market, $limit);
    }

    /**
     * @return $this
     */
    public function fetch(): self
    {
        $request = $this->request()->fetch();

        $this->result = $request->result();

        return $this;
    }

    /**
     * @return \App\Services\DataForSeo\Requests\AbstractRequest
     */
    private function request(): AbstractRequest
    {
        /** @var AbstractRequest $request */
        $request = null;

        if ($this->params->isDomain()) $request = new DomainSearch();
        if ($this->params->isKeywordList()) $request = new KeywordList();
        if ($this->params->isSingleKeyword()) $request = new SingleKeyword();

        $request->setParams($this->params);

        return $request;
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return $this->result;
    }
}
