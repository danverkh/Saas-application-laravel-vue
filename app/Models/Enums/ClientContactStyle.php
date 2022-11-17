<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum ClientContactStyle: string
{
    use InvokableCases;

    case FORMAL = 'formal';
    case INFORMAL = 'informal';
}
