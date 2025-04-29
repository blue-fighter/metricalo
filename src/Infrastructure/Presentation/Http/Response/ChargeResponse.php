<?php

namespace App\Infrastructure\Presentation\Http\Response;

final readonly class ChargeResponse
{

    public function __construct(
        private string $transactionId,
        private string $dateOfCreating,
        private string $amount,
        private string $currency,
        private string $cardBin,
    ) {}

    public function __toString(): string
    {
        return json_encode([
            'transaction_id' => $this->transactionId,
            'date_of_creating' => $this->dateOfCreating,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'card_bin' => $this->cardBin,
        ]);
    }
}
