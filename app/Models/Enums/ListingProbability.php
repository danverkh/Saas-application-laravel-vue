<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum ListingProbability: string
{
    use InvokableCases;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
