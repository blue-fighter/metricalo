<?php

namespace App\Infrastructure\Integrations\ACI\Factory;

use App\Application\Contracts\PurchaseRequest;
use App\Infrastructure\Integrations\ACI\Request\DebitRequest;

interface DebitRequestFactoryInterface
{
    public function create(PurchaseRequest $request): DebitRequest;
}