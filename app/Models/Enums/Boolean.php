<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum Boolean: string
{
    use InvokableCases;

    case TRUE = 'TRUE';
    case FALSE = 'FALSE';
}
