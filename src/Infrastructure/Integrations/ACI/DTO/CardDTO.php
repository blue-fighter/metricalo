<?php

namespace App\Infrastructure\Integrations\ACI\DTO;

final readonly class CardDTO
{
    public function __construct(
        private string $number,
        private string $expiryMonth,
        private string $expiryYear,
        private int $cvv,
    ) {}

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getExpiryMonth(): string
    {
        return $this->expiryMonth;
    }

    public function getExpiryYear(): string
    {
        return $this->expiryYear;
    }

    public function getCvv(): int
    {
        return $this->cvv;
    }
}