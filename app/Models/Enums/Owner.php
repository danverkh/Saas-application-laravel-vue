<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum Owner: string
{
    use InvokableCases;

    case Ltd = 'hPage Ltd.';
    case GmbH = 'LOGOS Performance GmbH';
}
