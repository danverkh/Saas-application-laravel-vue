<?php

namespace App\Services\DataForSeo\Requests;

use App\Services\DataForSeo\Result;

class GoogleAdsSearchVolume extends AbstractRequest
{
    /**
     * @return Result
     */
    public function fetch(): Result
    {
        $params[] = [
            'keywords'        => $this->params->get('keywords'),
            'location_name'   => $this->params->getLocation(),
            'language_name'   => $this->params->getLanguage(),
            'search_partners' => true,
        ];

        $response = $this->client->post('/v3/keywords_data/google_ads/search_volume/live', $params);

        $result   = data_get($response, 'tasks.0.result.0', []) ?? [];
        $results  = data_get($response, 'tasks.0.result', []) ?? [];

        $data = [
            'keywords' => $this->params->get('keywords'),
        ];

        return new Result($data, [], $result, $results);
    }
}
