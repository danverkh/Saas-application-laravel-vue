<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $cpc          = data_get($this, 'keyword_data.keyword_info.cpc', 0) ?? 0;
        $searchVolume = data_get($this, 'keyword_data.keyword_info.search_volume', 0) ?? 0;

        return [
            'keyword'                  => data_get($this, 'keyword_data.keyword'),
            'cpc'                      => $cpc,
            'search_volume'            => $searchVolume,
            'current_rank'             => data_get($this, 'ranked_serp_element.serp_item.rank_absolute', 0) ?? 0,
            'url'                      => data_get($this, 'ranked_serp_element.serp_item.url'),
            'projected_clicks'         => $searchVolume * 0.18,
            'projected_traffic_volume' => $searchVolume * $cpc * 0.18,
            'maximum_cost'             => $searchVolume * $cpc * 0.18 * 0.3,
        ];
    }
}
