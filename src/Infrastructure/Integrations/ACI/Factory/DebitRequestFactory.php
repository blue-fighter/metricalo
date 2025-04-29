<?php

namespace App\Infrastructure\Integrations\ACI\Factory;

use App\Application\Contracts\PurchaseRequest;
use App\Domain\Enum\CardNetwork;
use App\Domain\Enum\Currency;
use App\Infrastructure\Integrations\ACI\DTO\CardDTO;
use App\Infrastructure\Integrations\ACI\Enum\PaymentType;
use App\Infrastructure\Integrations\ACI\Request\DebitRequest;

/**
 * Request to perform debit payment on ACI
 */
class DebitRequestFactory implements DebitRequestFactoryInterface
{
    const string ENTITY_ID = '8ac7a4c79394bdc801939736f17e063d';
    const string CARD_NUMBER = '4200000000000000';

    public function create(PurchaseRequest $request): DebitRequest
    {
        return new DebitRequest(
            entityId: self::ENTITY_ID,
            amount: $request->getAmount(),
            currency: Currency::EUR->value,
            paymentBrand: CardNetwork::VISA->value,
            paymentType: PaymentType::DEBIT,
            card: new CardDTO(
                number: self::CARD_NUMBER,
                expiryMonth: $request->getExpireMonth(),
                expiryYear: $request->getExpireYear(),
                cvv: $request->getCvv(),
            )
        );
    }
}