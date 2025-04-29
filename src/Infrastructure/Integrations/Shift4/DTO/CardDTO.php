<?php

namespace App\Infrastructure\Integrations\Shift4\DTO;

final readonly class CardDTO
{
    public function __construct(
        private string $number,
        private string $expMonth,
        private string $expYear,
        private int $cvc,
    ) {}

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getExpMonth(): string
    {
        return $this->expMonth;
    }

    public function getExpYear(): string
    {
        return $this->expYear;
    }

    public function getCvc(): int
    {
        return $this->cvc;
    }
}