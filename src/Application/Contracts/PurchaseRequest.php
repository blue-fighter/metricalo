<?php

namespace App\Application\Contracts;

final readonly class PurchaseRequest
{
    public function __construct(
        private string $expireMonth,
        private string $expireYear,
        private string $amount,
        private string $currency,
        private string $number,
        private int $cvv,
    ) {}

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getCvv(): int
    {
        return $this->cvv;
    }

    public function getExpireMonth(): string
    {
        return $this->expireMonth;
    }

    public function getExpireYear(): string
    {
        return $this->expireYear;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}