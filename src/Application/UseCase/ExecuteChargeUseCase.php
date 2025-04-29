<?php

namespace App\Application\UseCase;

use App\Application\Contracts\PurchaseRequest;
use App\Application\Contracts\PurchaseResponse;
use App\Application\Factory\PurchaseServiceFactoryInterface;

readonly class ExecuteChargeUseCase
{
    public function __construct(
        private PurchaseServiceFactoryInterface $purchaseServiceFactory,
    ) {}

    public function execute(
        string $gateway,
        PurchaseRequest $request,
    ): PurchaseResponse
    {
        $purchaseService = $this->purchaseServiceFactory->create($gateway);
        return $purchaseService->purchase($request);
    }
}