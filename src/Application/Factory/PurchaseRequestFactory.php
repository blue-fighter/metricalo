<?php

namespace App\Application\Factory;

use App\Application\Contracts\PurchaseRequest;

class PurchaseRequestFactory implements PurchaseRequestFactoryInterface
{
    public function create(
        string $expireMonth,
        string $expireYear,
        string $amount,
        string $currency,
        string $number,
        int $cvv,
    ): PurchaseRequest {
        return new PurchaseRequest(
            $expireMonth,
            $expireYear,
            $amount,
            $currency,
            $number,
            $cvv,
        );
    }
}