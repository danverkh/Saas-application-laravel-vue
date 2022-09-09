<?php

namespace App\Services\DataForSeo;

use App\Services\DataForSeo\Requests\DomainSearch;
use App\Services\DataForSeo\Requests\KeywordList;
use App\Services\DataForSeo\Requests\AbstractRequest;
use App\Services\DataForSeo\Requests\SingleKeyword;
use Illuminate\Pipeline\Pipeline;

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
        $this->result = $this->request()->fetch();

        return $this;
    }

    /**
     * @return \App\Services\DataForSeo\Requests\AbstractRequest
     */
    private function request(): AbstractRequest
    {
        $request = match ($this->params->searchType) {
            Params::TYPE_DOMAIN => new DomainSearch(),
            Params::TYPE_KEYWORD_LIST => new KeywordList(),
            Params::TYPE_SINGLE_KEYWORD => new SingleKeyword(),
        };

        $request->setParams($this->params);

        return $request;
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return app(Pipeline::class)
            ->send($this->result)
            ->through([
                \App\Services\DataForSeo\Modifiers\UniqueKeywords::class,
                \App\Services\DataForSeo\Modifiers\CalculateMissingValues::class,
                \App\Services\DataForSeo\Modifiers\SortResults::class,
            ])
            ->thenReturn();
    }
}
