<?php

namespace App\Application\Contracts;

interface PurchaseServiceInterface
{
    public function purchase(PurchaseRequest $request): PurchaseResponse;
}