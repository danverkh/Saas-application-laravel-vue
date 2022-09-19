<?php

namespace App\Services\DataForSeo\Modifiers;

use App\Services\DataForSeo\Modifiers\Actions\CalculateMissingValues;
use App\Services\DataForSeo\Modifiers\Actions\SortResults;
use App\Services\DataForSeo\Modifiers\Actions\UniqueKeywords;
use App\Services\DataForSeo\Result;
use Illuminate\Pipeline\Pipeline;

class DomainSearchModifier implements ModifierContract
{
    /**
     * @param Result $result
     *
     * @return array
     */
    public function handle(Result $result): array
    {
        return app(Pipeline::class)
            ->send(
                $result->items()
            )
            ->through([
                UniqueKeywords::class,
                CalculateMissingValues::class,
                SortResults::class,
            ])
            ->thenReturn();
    }
}
