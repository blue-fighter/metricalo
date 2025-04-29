<?php

namespace App\Infrastructure\Integrations\ACI\Request;

use App\Infrastructure\Integrations\ACI\DTO\CardDTO;
use App\Infrastructure\Integrations\ACI\Enum\PaymentType;

final readonly class DebitRequest implements AciRequestInterface
{
    /**
     * For some reason it doesn't work without cardholder
     * So I hardcoded it right here
     * There was no reqs about cardholder in Tech task But I think it should be there
     */
    const string CARD_HOLDER = 'Jane Jones';
    public function __construct(
        private string $entityId,
        private string $amount,
        private string $currency,
        private string $paymentBrand,
        private PaymentType $paymentType,
        private CardDTO $card,
    ) {}

    public function getBody(): array
    {
        return [
            'entityId' => $this->entityId,
            'amount' => bcdiv($this->amount, '100', 2),
            'currency' => $this->currency,
            'paymentBrand' => $this->paymentBrand,
            'paymentType' => $this->paymentType->value,
            'card.number' => $this->card->getNumber(),
            'card.holder' => self::CARD_HOLDER,
            'card.expiryMonth' => sprintf("%02d", $this->card->getExpiryMonth()),
            'card.expiryYear' => sprintf("%d%d", substr(date("Y"), 0, 2), $this->card->getExpiryYear()),
            'card.cvv' => (string) $this->card->getCvv(),
        ];
    }
}