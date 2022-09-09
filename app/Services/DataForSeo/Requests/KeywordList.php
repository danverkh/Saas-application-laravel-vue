<?php

namespace App\Services\DataForSeo\Requests;

class KeywordList extends AbstractRequest
{
    /**
     * @return array
     */
    public function fetch(): array
    {
        $keywords = preg_split('/[,;]+/', $this->params->query);

        if (!is_array($keywords) || !count($keywords)) {
            return [];
        }

        $filteredKeywords = $this->filterSpecialCharacters($keywords);

        $result = $this->getDataForKeywordOrKeywords($filteredKeywords);
        $items  = data_get($result, 'tasks.0.result');

        return collect($items)
            ->map(static function ($item) {
                return [
                    'keyword'       => $item['keyword'],
                    'search_volume' => $item['search_volume'] ?? 0,
                    'cpc'           => $item['high_top_of_page_bid'] ?? 0,
                    'competition'   => $item['competition_index'] ?? 0,
                ];
            })
            ->toArray();
    }

    /**
     * @param array $keywords
     *
     * @return array|mixed|string|string[]|null
     */
    private function getDataForKeywordOrKeywords(array $keywords): mixed
    {
        $filteredKeywords = $this->filterSpecialCharacters($keywords);

        $params[] = [
            'keywords'      => $filteredKeywords,
            'location_name' => $this->params->getLocation(),
            'language_name' => $this->params->getLanguage(),
        ];

        return $this->client->post('/v3/keywords_data/google_ads/search_volume/live', $params);
    }

    /**
     * @param array $keywords
     *
     * @return array
     */
    private function filterSpecialCharacters(array $keywords): array
    {
        $specialCharacters = [
            '~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '{', '}', '[', ']', '|', '\\',
            '/', ':', ';', '"', '\'', '<', '>', ',', '.', '?',
        ];

        return collect($keywords)
            ->map(static function ($keyword) use ($specialCharacters) {
                return str_replace($specialCharacters, ' ', $keyword);
            })
            ->toArray();
    }
}

