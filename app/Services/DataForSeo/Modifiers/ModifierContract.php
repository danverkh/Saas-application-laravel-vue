<?php

namespace App\Services\DataForSeo\Modifiers;

interface ModifierContract
{
    public function handle(array $result): array;
}
