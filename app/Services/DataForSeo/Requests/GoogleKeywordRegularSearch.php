<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Result;

class GoogleKeywordRegularSearch extends AbstractRequest
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
            ] + $this->params->all();

        $result = $this->client->post('/v3/serp/google/organic/live/regular', $params);
        $items  = data_get($result, 'tasks.0.result.0.items', []);

        $data = [
            'keywords' => $this->params->get('keyword'),
        ];

        return new Result($data, $items);
    }
}
