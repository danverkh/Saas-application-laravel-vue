<?php

namespace App\Services\DataForSeo\Modifiers;

use App\Services\DataForSeo\Result;

interface ModifierContract
{
    public function handle(Result $result): array;
}
