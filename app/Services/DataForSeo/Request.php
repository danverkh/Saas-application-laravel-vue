<?php

namespace App\Services\DataForSeo;

use App\Services\DataForSeo\Modifiers\CalculateMissingValues;
use App\Services\DataForSeo\Modifiers\SortResults;
use App\Services\DataForSeo\Modifiers\UniqueKeywords;
use App\Services\DataForSeo\Requests\DomainSearch;
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
        $request = new DomainSearch();
        $request->setParams($this->params);

        $this->result = $request->fetch();

        return $this;
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return app(Pipeline::class)
            ->send($this->result)
            ->through([
                UniqueKeywords::class,
                CalculateMissingValues::class,
                SortResults::class,
            ])
            ->thenReturn();
    }
}
