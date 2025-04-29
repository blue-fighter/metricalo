<?php

namespace App\Application\Contracts;
use DateTimeInterface;

final readonly class PurchaseResponse
{
    public function __construct(
        private string $transactionId,
        private DateTimeInterface $creationDate,
        private string $amount,
        private string $currency,
        private string $cardBin,
    ) {}

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate->format('Y-m-d');
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCardBin(): string
    {
        return $this->cardBin;
    }
}