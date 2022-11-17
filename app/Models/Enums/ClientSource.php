<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum ClientSource: string
{
    use InvokableCases;

    case COLD_CALL = 'Cold Call';
    case COLD_MAIL = 'Cold Mail';
    case LINKEDIN = 'LinkedIn';
    case OTHER = 'OTHER';
}
