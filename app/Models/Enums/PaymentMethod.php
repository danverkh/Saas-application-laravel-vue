<?php

namespace App\Models\Enums;

use ArchTech\Enums\InvokableCases;

enum PaymentMethod: string
{
    use InvokableCases;

    case WIRE_TRANSFER = 'wire_transfer';
    case DIRECT_DEBIT = 'direct_debit';
    case CREDIT_CARD = 'credit_card';
}
