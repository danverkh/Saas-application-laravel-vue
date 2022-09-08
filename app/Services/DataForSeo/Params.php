<?php

namespace App\Services\DataForSeo;

class Params
{
    public const TYPE_DOMAIN = 'DOMAIN_SEARCH';
    public const TYPE_KEYWORD_LIST = 'KEYWORD_LIST';
    public const TYPE_SINGLE_KEYWORD = 'SINGLE_KEYWORD';

    private $languageByLocation = [
        'AT' => ['location' => 'Austria', 'language' => 'German'],
        'BE' => ['location' => 'Belgium', 'language' => 'French'],
        'CH' => ['location' => 'Switzerland', 'language' => 'German'],
        'DE' => ['location' => 'Germany', 'language' => 'German'],
        'FR' => ['location' => 'France', 'language' => 'French'],
        'IT' => ['location' => 'Italy', 'language' => 'Italian'],
        'ES' => ['location' => 'Spain', 'language' => 'Spanish'],
        'UK' => ['location' => 'United Kingdom', 'language' => 'English'],
        'US' => ['location' => 'United States', 'language' => 'English'],
    ];

    public string $query;
    public string $market;
    public int    $limit;
    public string $searchType;

    /**
     * @param string $query
     * @param string $market
     * @param int    $limit
     */
    public function __construct(string $query, string $market, int $limit)
    {
        $this->query      = $query;
        $this->market     = $market;
        $this->limit      = $limit;
        $this->searchType = $this->getSearchTypeForQuery($query);
    }

    /**
     * @param string $userQuery
     *
     * @return string
     */
    private function getSearchTypeForQuery(string $userQuery): string
    {
        if (str_contains($userQuery, '.')) {
            return self::TYPE_DOMAIN;
        }
        if (str_contains($userQuery, ',') || str_contains($userQuery, ';')) {
            return self::TYPE_KEYWORD_LIST;
        }
        return self::TYPE_SINGLE_KEYWORD;
    }

    /**
     * @return bool
     */
    public function isDomain(): bool
    {
        return $this->searchType === self::TYPE_DOMAIN;
    }

    /**
     * @return bool
     */
    public function isKeywordList(): bool
    {
        return $this->searchType === self::TYPE_KEYWORD_LIST;
    }

    /**
     * @return bool
     */
    public function isSingleKeyword(): bool
    {
        return $this->searchType === self::TYPE_SINGLE_KEYWORD;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function idnHostToAscii(string $url): string
    {
        $urlArray = parse_url($url);

        // no scheme available? e.g. just "demouser.de" => add scheme
        if (!\array_key_exists('scheme', $urlArray)) {
            $urlArray = parse_url('http://' . $url);
        }

        if ($urlArray === false) {
            return $url;
        }

        if (!\array_key_exists('host', $urlArray)) {
            return $url;
        }

        $originalHost = $urlArray['host'];
        $asciiHost    = \idn_to_ascii($originalHost, 0, \INTL_IDNA_VARIANT_UTS46);

        if ($asciiHost === false) {
            return $url;
        }

        return \str_replace($originalHost, $asciiHost, $url);
    }
}
