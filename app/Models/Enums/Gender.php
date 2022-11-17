<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum Gender: string
{
    use InvokableCases;

    case MALE = 'm';
    case FEMALE = 'f';
}
