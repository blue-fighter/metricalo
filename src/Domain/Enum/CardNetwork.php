<?php

namespace App\Domain\Enum;

enum CardNetwork: string
{
    case AMEX = 'AMEX';
    case CHINA_UNIONPAY = 'CHINA_UNIONPAY';
    case DINERS = 'DINERS';
    case DISCOVER = 'DISCOVER';
    case INSTAPAYMENT = 'INSTAPAYMENT';
    case JCB = 'JCB';
    case LASER = 'LASER';
    case MAESTRO = 'MAESTRO';
    case MASTERCARD = 'MASTERCARD';
    case MIR = 'MIR';
    case UATP = 'UATP';
    case VISA = 'VISA';
}