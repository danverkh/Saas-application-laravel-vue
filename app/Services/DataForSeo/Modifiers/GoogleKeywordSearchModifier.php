<?php

namespace App\Services\DataForSeo\Modifiers;

use App\Services\DataForSeo\Modifiers\Actions\MoveDomainToTheTop;
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
     * @param array $result
     *
     * @return array
     */
    public function handle(array $result): array
    {
        return app(Pipeline::class)
            ->send($result, $this->domain)
            ->through([
                MoveDomainToTheTop::class,
            ])
            ->thenReturn();
    }
}
