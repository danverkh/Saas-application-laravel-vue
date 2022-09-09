<?php

namespace App\Services\DataForSeo\Requests;

class SingleKeyword extends AbstractRequest
{
    /**
     * @return array
     */
    public function fetch(): array
    {
        return array_merge(
            (new KeywordList($this->params))->fetch(),
            $this->getKeywordsForKeyword($this->params->query)
        );
    }

    /**
     * @param string $keyword
     *
     * @return array
     */
    private function getKeywordsForKeyword(string $keyword): array
    {
        $params[] = [
            'keywords'      => [$keyword],
            'location_name' => $this->params->getLocation(),
            'language_name' => $this->params->getLanguage(),
        ];

        $result = $this->client->post('/v3/keywords_data/google/keywords_for_keywords/live', $params);
        $items  = data_get($result, 'tasks.0.result', []);

        return collect($items)
            ->map(static function ($item) {
                return [
                    'keyword'       => $item['keyword'],
                    'search_volume' => $item['search_volume'] ?? 0,
                    'cpc'           => $item['cpc'] ?? 0,
                    'competition'   => $item['competition'] ?? 0,
                ];
            })
            ->toArray();
    }
}

