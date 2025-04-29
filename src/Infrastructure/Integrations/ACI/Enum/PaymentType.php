<?php

namespace App\Infrastructure\Integrations\ACI\Enum;

enum PaymentType: string
{
    case PRE_AUTHORIZE_PAYMENT = 'PA';
    case CAPTURE_PAYMENT = 'CP';
    case DEBIT = 'DB';
}