<?php

namespace App\Application\Factory;

use App\Application\Contracts\PurchaseServiceInterface;

interface PurchaseServiceFactoryInterface
{
    public function create(string $gateway): PurchaseServiceInterface;
}