<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Result;

class GoogleKeywordAdvancedSearch extends AbstractRequest
{
    /**
     * @return Result
     */
    public function fetch(): Result
    {
        $params[] = [
            'keyword'       => $this->params->get('keyword'),
            'location_name' => $this->params->getLocation(),
            'language_name' => $this->params->getLanguage(),
            'limit'         => $this->params->limit,
        ];

        $result = $this->client->post('/v3/serp/google/organic/live/advanced', $params);

        $items = data_get($result, 'tasks.0.result.0.items', []) ?? [];

        $data = [
            'hasPaidAds' => collect(data_get($result, 'tasks.0.result.0.item_types', []))->contains('paid'),
            'keywords'   => $this->params->get('keyword'),
        ];

        $items = collect($items)
            ->map(static function ($item) {
                return [
                    'url'         => data_get($item, 'url'),
                    'title'       => data_get($item, 'title'),
                    'description' => data_get($item, 'description'),
                    'breadcrumb'  => data_get($item, 'breadcrumb'),
                ];
            })
            ->reject(static fn($item) => min(array_values($item)) === null)
            ->toArray();

        return new Result($data, $items);
    }
}
