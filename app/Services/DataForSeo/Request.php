<?php

namespace App\Services\DataForSeo;

use App\Services\DataForSeo\Modifiers\DomainSearchModifier;
use App\Services\DataForSeo\Modifiers\GoogleKeywordSearchModifier;
use App\Services\DataForSeo\Requests\DomainSearch;
use App\Services\DataForSeo\Requests\GoogleKeywordSearch;

class Request
{
    public const TYPE_DOMAIN_SEARCH  = 'domain';
    public const TYPE_GOOGLE_KEYWORD = 'google-keyword';

    /**
     * @var \App\Services\DataForSeo\Params
     */
    private Params $params;

    /**
     * @var array
     */
    private array $result;

    /**
     * @var string
     */
    private string $requestType;

    /**
     * @param string $requestType
     * @param string $query
     * @param string $market
     * @param int    $limit
     */
    public function __construct(string $requestType, string $query, string $market, int $limit)
    {
        $this->params = new Params($query, $market, $limit);

        $this->requestType = $requestType;
    }

    /**
     * @return $this
     */
    public function fetch(): self
    {
        $request = match ($this->requestType) {
            self::TYPE_DOMAIN_SEARCH => new DomainSearch(),
            self::TYPE_GOOGLE_KEYWORD => new GoogleKeywordSearch(),
        };

        $request->setParams($this->params);

        $this->result = $request->fetch();

        return $this;
    }

    /**
     * @param array|null $params
     *
     * @return array
     */
    public function result(?array $params = null): array
    {
        /** @var \App\Services\DataForSeo\Modifiers\ModifierContract $modifier */
        $modifier = match ($this->requestType) {
            self::TYPE_DOMAIN_SEARCH => new DomainSearchModifier(),
            self::TYPE_GOOGLE_KEYWORD => new GoogleKeywordSearchModifier($params['domain']),
        };

        return $modifier->handle($this->result);
    }
}
