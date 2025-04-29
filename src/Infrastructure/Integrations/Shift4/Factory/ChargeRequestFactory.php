<?php

namespace App\Infrastructure\Integrations\Shift4\Factory;

use App\Application\Contracts\PurchaseRequest;
use App\Infrastructure\Integrations\Shift4\DTO\CardDTO;
use App\Infrastructure\Integrations\Shift4\Request\ChargeRequest;

class ChargeRequestFactory implements ChargeRequestFactoryInterface
{
    const string CARD_NUMBER = '4242424242424242';

    public function create(PurchaseRequest $request): ChargeRequest
    {
        return new ChargeRequest(
            amount: $request->getAmount(),
            currency: $request->getCurrency(),
            card: new CardDTO(
                number: self::CARD_NUMBER,
                expMonth: $request->getExpireMonth(),
                expYear: $request->getExpireYear(),
                cvc: $request->getCvv(),
            )
        );
    }
}