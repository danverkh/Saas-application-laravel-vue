<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Result;

class DomainSearch extends AbstractRequest
{
    /**
     * @return Result
     */
    public function fetch(): Result
    {
        $data = [];

        $items = $this->domainBySearchEngineRanking(
            $this->ensureCorrectDomainFormat($this->params->get('domain'))
        );

        return new Result($data, $items);
    }

    /**
     * @param string $domain
     * @param int    $limit
     *
     * @return array
     */
    private function domainBySearchEngineRanking(string $domain, int $limit = 300): array
    {
        $requestCounter = 0;

        do {
            $params[] = [
                'target'        => $domain,
                'location_name' => $this->params->getLocation(),
                'language_name' => $this->params->getLanguage(),
                'limit'         => $limit,
                'order_by'      => ['keyword_data.keyword_info.cpc,desc', 'keyword_data.keyword_info.search_volume,desc'],
                'filters'       => [
                    ['ranked_serp_element.serp_item.rank_group', '>', 11],
                    'and',
                    ['ranked_serp_element.serp_item.rank_group', '<', 30],
                    'and',
                    ['keyword_data.keyword_info.search_volume', '>', 50],
                    'and',
                    ['keyword_data.keyword_info.search_volume', '<', 10000],

                    // legacy
                    //['ranked_serp_element.serp_item.rank_group', '<', 200],
                    //'and',
                    //['keyword_data.keyword_info.search_volume', '<', 35000],
                ],
            ];

            $result = $this->client->post('/v3/dataforseo_labs/ranked_keywords/live', $params);
            $requestCounter++;

            $items = data_get($result, 'tasks.0.result.0.items', []) ?? [];

            // lower filters
            $params[0]['filters'][0][2] = round($params[0]['filters'][0][2] * 0.5);
            $params[0]['filters'][2][2] = round($params[0]['filters'][2][2] * 2);
            $params[0]['filters'][4][2] = round($params[0]['filters'][4][2] * 0.8);
            $params[0]['filters'][6][2] = round($params[0]['filters'][6][2] * 1.5);
        } while (count($items) <= 15 && $requestCounter <= 4);

        return collect($items)
            ->map(function ($item) use ($domain, $items) {
                if ($this->isBrandKeyword($item['keyword_data']['keyword'], $domain)) {
                    return null;
                }

                return [
                    'keyword'       => $item['keyword_data']['keyword'],
                    'search_volume' => $item['keyword_data']['keyword_info']['search_volume'] ?? 0,
                    'cpc'           => $item['keyword_data']['keyword_info']['cpc'] ?? $this->findSimilarKeywordCpc($item['keyword_data']['keyword'], $items),
                    'competition'   => $item['keyword_data']['keyword_info']['competition'] ?? 0,
                    'current_rank'  => $item['ranked_serp_element']['serp_item']['rank_group'] ?? 0,
                    'traffic_cost'  => $item['ranked_serp_element']['serp_item']['estimated_paid_traffic_cost'] ?? 0,
                    'url'           => $item['ranked_serp_element']['serp_item']['url'] ?? '/',
                ];
            })
            ->reject(static fn($item) => $item === null)
            ->toArray();
    }

    /**
     * @param string $domain
     *
     * @return array
     */
    private function domainByWebsiteContent(string $domain): array
    {
        $params[] = [
            'target'        => $domain,
            'location_name' => $this->params->getLocation(),
            'language_name' => $this->params->getLanguage(),
        ];

        $result = $this->client->post('/v3/keywords_data/google/keywords_for_site/live', $params);
        $items  = data_get($result, 'tasks.0.result', []) ?? [];

        return collect($items)
            ->map(function ($item) use ($domain) {
                if ($this->isBrandKeyword($item['keyword'], $domain)) {
                    return null;
                }

                return [
                    'keyword'       => $item['keyword'],
                    'search_volume' => (int)($item['search_volume'] ?? 0),
                    'cpc'           => (float)($item['cpc'] ?? 3),
                    'competition'   => (float)($item['competition'] ?? 0),
                    'market'        => $this->params->market,
                ];
            })
            ->filter()
            ->toArray();
    }

    /**
     * @param string $inputDomain
     *
     * @return string
     */
    private function ensureCorrectDomainFormat(string $inputDomain): string
    {
        $inputDomain = str_replace('http://', 'https://', $inputDomain);

        if (!str_contains($inputDomain, 'https://')) {
            $inputDomain = 'https://' . $inputDomain;
        }

        return $this->idnHostToAscii(
            $this->extractDomain($inputDomain)
        );
    }

    /**
     * @param $inputDomain
     *
     * @return string
     */
    private function ensureCorrectDomainWithOptionalSubdomainFormatForRequest($inputDomain): string
    {
        if (!str_contains($inputDomain, 'https://')) {
            $inputDomain = 'https://' . $inputDomain;
        }
        return $this->idnHostToAscii($inputDomain);
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

    /**
     * @param string $url
     *
     * @return string
     */
    private function extractDomain(string $url): string
    {
        $pieces = \parse_url($url);
        $domain = $pieces['host'] ?? '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z.]{2,10})$/i', $domain, $matches)) {
            $matches['domain'] = \preg_replace('/^www./', '', $matches['domain']);
            return $matches['domain'];
        }
        return '';
    }

    /**
     * @param string $keyword
     * @param string $domain
     *
     * @return bool
     */
    private function isBrandKeyword(string $keyword, string $domain): bool
    {
        return str_contains($keyword, explode(".", $domain)[0]);
    }

    /**
     * @param string $keyword
     * @param array  $items
     *
     * @return float
     */
    private function findSimilarKeywordCpc(string $keyword, array $items): float
    {
        $mostSimilarKeyword = collect($items)
            ->filter(static fn($item) => $item['keyword_data']['keyword_info']['cpc'] !== null)
            ->map(static function ($item) use ($keyword) {
                similar_text($keyword, $item['keyword_data']['keyword'], $percent);

                return [
                    'cpc'        => $item['keyword_data']['keyword_info']['cpc'],
                    'similarity' => $percent,
                ];
            })
            ->sortByDesc('similarity')
            ->first();

        if ($mostSimilarKeyword['similarity'] > 40) {
            return $mostSimilarKeyword['cpc'];
        }
        return 0.52;
    }
}
