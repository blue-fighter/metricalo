<?php

namespace App\Infrastructure\Integrations\Shift4\Request;

use App\Infrastructure\Integrations\Shift4\DTO\CardDTO;

final readonly class ChargeRequest implements Shift4RequestInterface
{
    public function __construct(
        private string $amount,
        private string $currency,
        private CardDTO $card,
    ) {}

    public function getBody(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'card' => [
                'number' => $this->card->getNumber(),
                'expMonth' => $this->card->getExpMonth(),
                'expYear' => $this->card->getExpYear(),
                'cvc' => (string) $this->card->getCvc(),
            ],
        ];
    }
}