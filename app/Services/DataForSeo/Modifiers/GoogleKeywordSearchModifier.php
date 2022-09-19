<?php

namespace App\Services\DataForSeo\Modifiers;

use App\Services\DataForSeo\Result;
use Illuminate\Pipeline\Pipeline;

class GoogleKeywordSearchModifier implements ModifierContract
{
    /**
     * @var string
     */
    private string $domain;

    /**
     * @param string $domain
     */
    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param Result $result
     *
     * @return array
     */
    public function handle(Result $result): array
    {
        $data = $result->additionalData();

        return app(Pipeline::class)
            ->send($result->items())
            ->through([
                "App\Services\DataForSeo\Modifiers\Actions\MoveDomainToTheTop:{$this->domain}",
                "App\Services\DataForSeo\Modifiers\Actions\Limit:5",
                "App\Services\DataForSeo\Modifiers\Actions\PrioritizeKeywordDomain:{$data['keywords']}",
                "App\Services\DataForSeo\Modifiers\Actions\AppendAd:{$data['hasPaidAds']}",
            ])
            ->thenReturn();
    }
}
