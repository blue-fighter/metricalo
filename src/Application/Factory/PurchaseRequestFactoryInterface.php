<?php

namespace App\Application\Factory;

use App\Application\Contracts\PurchaseRequest;

interface PurchaseRequestFactoryInterface
{
    public function create(
        string $expireMonth,
        string $expireYear,
        string $amount,
        string $currency,
        string $number,
        int $cvv,
    ): PurchaseRequest;

}