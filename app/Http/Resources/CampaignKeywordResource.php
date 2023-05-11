<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CampaignKeywordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'keyword'          => $this->keyword,
            'domain'           => $this->domain,
            'search_volume'    => $this->search_volume,
            'maximum_cost'     => $this->maximum_cost,
            'cpc'              => $this->cpc,
            'termination_date' => $this->termination_date,
            'creation_date'    => Carbon::parse($this->creation_date)?->format('Y-m-d'),
            'rankings'         => $this->rankings()
                                       ->latest()
                                       ->limit(30)
                                       ->get()
                                       ->mapWithKeys(static fn($ranking) => [$ranking->created_at->format('Y-m-d') => $ranking->rank]),
        ];
    }
}
