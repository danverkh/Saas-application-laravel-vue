<?php

namespace App\Services\DataForSeo;

use App\Services\DataForSeo\Modifiers\DomainSearchModifier;
use App\Services\DataForSeo\Modifiers\GoogleKeywordAdvancedSearchModifier;
use App\Services\DataForSeo\Requests\DomainSearch;
use App\Services\DataForSeo\Requests\GoogleAdsKeywordsForSite;
use App\Services\DataForSeo\Requests\GoogleAdsSearchVolume;
use App\Services\DataForSeo\Requests\GoogleKeywordAdvancedSearch;
use App\Services\DataForSeo\Requests\GoogleKeywordRegularSearch;

class Request
{
    public const TYPE_DOMAIN_SEARCH                = 'domain';
    public const TYPE_GOOGLE_KEYWORD_REGULAR       = 'google-keyword-regular';
    public const TYPE_GOOGLE_KEYWORD_ADVANCED      = 'google-keyword-advanced';
    public const TYPE_GOOGLE_ADS_SEARCH_VOLUME     = 'google-ads-search-volume';
    public const TYPE_GOOGLE_ADS_KEYWORDS_FOR_SITE = 'google-ads-keywords-for-site';

    /**
     * @var \App\Services\DataForSeo\Params
     */
    private Params $params;

    /**
     * @var Result
     */
    private Result $result;

    /**
     * @var string
     */
    private string $requestType;

    /**
     * @param array  $params
     * @param string $market
     * @param int    $limit
     *
     * @return \App\Services\DataForSeo\Request
     */
    public function params(array $params, string $market, int $limit = 500): self
    {
        $this->params = new Params($params, $market, $limit);

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function requestType(string $type): self
    {
        $this->requestType = $type;

        return $this;
    }

    /**
     * @return $this
     */
    public function fetch(): self
    {
        $request = match ($this->requestType) {
            self::TYPE_DOMAIN_SEARCH => new DomainSearch(),
            self::TYPE_GOOGLE_KEYWORD_REGULAR => new GoogleKeywordRegularSearch(),
            self::TYPE_GOOGLE_KEYWORD_ADVANCED => new GoogleKeywordAdvancedSearch(),
            self::TYPE_GOOGLE_ADS_SEARCH_VOLUME => new GoogleAdsSearchVolume(),
            self::TYPE_GOOGLE_ADS_KEYWORDS_FOR_SITE => new GoogleAdsKeywordsForSite(),
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
            self::TYPE_DOMAIN_SEARCH => new DomainSearchModifier($params['assistant']),
            self::TYPE_GOOGLE_KEYWORD_ADVANCED => new GoogleKeywordAdvancedSearchModifier($params['domain']),
        };

        return $modifier->handle($this->result);
    }

    /**
     * @return array
     */
    public function rawResult(): array
    {
        return $this->result->get();
    }

    /**
     * @return array
     */
    public function rawItems(): array
    {
        return $this->result->items();
    }
}
