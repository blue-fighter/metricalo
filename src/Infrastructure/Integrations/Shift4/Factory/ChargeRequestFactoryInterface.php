<?php

namespace App\Infrastructure\Integrations\Shift4\Factory;

use App\Application\Contracts\PurchaseRequest;
use App\Infrastructure\Integrations\Shift4\Request\ChargeRequest;

interface ChargeRequestFactoryInterface
{
    public function create(PurchaseRequest $request): ChargeRequest;
}