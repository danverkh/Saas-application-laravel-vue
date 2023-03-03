<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Result;

class GoogleAdsKeywordsForSite extends AbstractRequest
{
    /**
     * @return Result
     */
    public function fetch(): Result
    {
        $params[] = [
            'target'        => $this->params->get('target'),
            'location_name' => $this->params->getLocation(),
            'language_name' => $this->params->getLanguage(),
            'limit'         => $this->params->limit,
        ];

        $result = $this->client->post('/v3/keywords_data/google_ads/keywords_for_site/live', $params);

        $result = data_get($result, 'tasks.0.result', []) ?? [];

        $data = [];

        return new Result($data, [], $result);
    }
}
