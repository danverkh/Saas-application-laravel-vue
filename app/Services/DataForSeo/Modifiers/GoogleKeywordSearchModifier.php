<?php

namespace App\Services\DataForSeo\Modifiers;

use App\Services\DataForSeo\Modifiers\Actions\CalculateMissingValues;
use App\Services\DataForSeo\Modifiers\Actions\SortResults;
use App\Services\DataForSeo\Modifiers\Actions\UniqueKeywords;
use Illuminate\Pipeline\Pipeline;

class GoogleKeywordSearchModifier implements ModifierContract
{
    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param array $result
     *
     * @return array
     */
    public function handle(array $result): array
    {
        return app(Pipeline::class)
            ->send($result)
            ->through([
                UniqueKeywords::class,
                CalculateMissingValues::class,
                SortResults::class,
            ])
            ->thenReturn();
    }
}
