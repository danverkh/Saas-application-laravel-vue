<?php

namespace App\Services\DataForSeo\Modifiers;

use App\Services\DataForSeo\Modifiers\Actions\CalculateMissingValues;
use App\Services\DataForSeo\Modifiers\Actions\FilterItemsWhenSearchingForEmployees;
use App\Services\DataForSeo\Modifiers\Actions\SortResults;
use App\Services\DataForSeo\Modifiers\Actions\UniqueKeywords;
use App\Services\DataForSeo\Result;
use Illuminate\Pipeline\Pipeline;

class DomainSearchModifier implements ModifierContract
{
    /**
     * @var string|null
     */
    private string|null $assistant;

    /**
     * @var string
     */
    private string $domain;

    /**
     * @param string|null $assistant
     * @param string      $domain
     */
    public function __construct(string|null $assistant, string $domain)
    {
        $this->assistant = $assistant;
        $this->domain    = $domain;
    }

    /**
     * @param Result $result
     *
     * @return array
     */
    public function handle(Result $result): array
    {
        $pipes = [
            UniqueKeywords::class,
            CalculateMissingValues::class,
            "App\Services\DataForSeo\Modifiers\Actions\SortResults:{$this->domain},{$this->assistant}",
        ];

        if ($this->assistant === 'find_employees') {
            $pipes[] = FilterItemsWhenSearchingForEmployees::class;
        }

        return app(Pipeline::class)
            ->send(
                $result->items()
            )
            ->through($pipes)
            ->thenReturn();
    }
}
