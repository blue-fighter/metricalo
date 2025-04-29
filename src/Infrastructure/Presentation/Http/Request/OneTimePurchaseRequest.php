<?php

namespace App\Infrastructure\Presentation\Http\Request;

use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Currency;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final readonly class OneTimePurchaseRequest
{
    public function __construct(
        #[NotBlank, Type('numeric')]
        private int $amount,
        #[NotBlank, Currency]
        private string $currency,
        #[NotBlank, CardScheme(schemes: [CardScheme::MASTERCARD, CardScheme::VISA])]
        private string $cardNumber,
        #[NotBlank, Type('numeric'), Length(exactly: 2)]
        private int $cardExpYear,
        #[NotBlank, Type('numeric'), LessThanOrEqual(12)]
        private int $cardExpMonth,
        #[NotBlank, Type('numeric'), Length(exactly: 3)]
        private int $cardCVV,
    ) {}

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function getCardExpYear(): int
    {
        return $this->cardExpYear;
    }

    public function getCardExpMonth(): int
    {
        return $this->cardExpMonth;
    }

    public function getCardCVV(): int
    {
        return $this->cardCVV;
    }
}
