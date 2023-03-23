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
    public const DOMAIN_SEARCH                = 'domain';
    public const GOOGLE_KEYWORD_REGULAR       = 'google-keyword-regular';
    public const GOOGLE_KEYWORD_ADVANCED      = 'google-keyword-advanced';
    public const GOOGLE_ADS_SEARCH_VOLUME     = 'google-ads-search-volume';
    public const GOOGLE_ADS_KEYWORDS_FOR_SITE = 'google-ads-keywords-for-site';

    /**
     * @var Params
     */
    private Params $params;

    /**
     * @var Result
     */
    private Result $result;

    /**
     * @var string
     */
    private string $request;

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
     * @param string $name
     *
     * @return $this
     */
    public function request(string $name): self
    {
        $this->request = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function fetch(): self
    {
        $request = match ($this->request) {
            self::DOMAIN_SEARCH => new DomainSearch(),
            self::GOOGLE_KEYWORD_REGULAR => new GoogleKeywordRegularSearch(),
            self::GOOGLE_KEYWORD_ADVANCED => new GoogleKeywordAdvancedSearch(),
            self::GOOGLE_ADS_SEARCH_VOLUME => new GoogleAdsSearchVolume(),
            self::GOOGLE_ADS_KEYWORDS_FOR_SITE => new GoogleAdsKeywordsForSite(),
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
        $modifier = match ($this->request) {
            self::DOMAIN_SEARCH => new DomainSearchModifier($params['assistant'], $this->params->get('domain')),
            self::GOOGLE_KEYWORD_ADVANCED => new GoogleKeywordAdvancedSearchModifier($params['domain']),
        };

        return $modifier->handle($this->result);
    }

    /**
     * @return array
     */
    public function rawFirstResult(): array
    {
        return $this->result->get();
    }

    /**
     * @return array
     */
    public function rawResults(): array
    {
        return $this->result->all();
    }

    /**
     * @return array
     */
    public function rawItems(): array
    {
        return $this->result->items();
    }
}
