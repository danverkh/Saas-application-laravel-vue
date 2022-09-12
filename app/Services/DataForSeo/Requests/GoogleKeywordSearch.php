<?php

namespace App\Services\DataForSeo\Requests;

class GoogleKeywordSearch extends AbstractRequest
{
    /**
     * @return array
     */
    public function fetch(): array
    {
        $params[] = [
            'keyword'       => $this->params->query,
            'location_name' => $this->params->getLocation(),
            'language_name' => $this->params->getLanguage(),
            'limit'         => $this->params->limit,
        ];

        $result = $this->client->post('/v3/serp/google/organic/live/advanced', $params);
        $items  = data_get($result, 'tasks.0.result.0.items', []);

        return collect($items)
            ->map(static function ($item) {
                return [
                    'domain'      => data_get($item, 'domain'),
                    'url'         => data_get($item, 'url'),
                    'title'       => data_get($item, 'title'),
                    'description' => data_get($item, 'description'),
                    'breadcrumb'  => data_get($item, 'breadcrumb'),
                ];
            })
            ->toArray();
    }
}
