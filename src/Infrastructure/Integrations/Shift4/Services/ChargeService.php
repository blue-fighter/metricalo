<?php

namespace App\Infrastructure\Integrations\Shift4\Services;

use App\Application\Contracts\PurchaseRequest;
use App\Application\Contracts\PurchaseResponse;
use App\Application\Contracts\PurchaseServiceInterface;
use App\Infrastructure\Integrations\Shift4\Factory\ChargeRequestFactoryInterface;
use App\Infrastructure\Integrations\Shift4\Shift4Client;
use DateTimeImmutable;
final readonly class ChargeService implements PurchaseServiceInterface
{
    const string ACTION_URL = '/charges';

    public function __construct(
        private Shift4Client $client,
        private ChargeRequestFactoryInterface $chargeRequestFactory
    ) {}

    public function purchase(PurchaseRequest $request): PurchaseResponse
    {
        $request = $this->chargeRequestFactory->create($request);
        $response = $this->client->sendRequest(
            'POST',
            self::ACTION_URL,
            $request,
        );
        return new PurchaseResponse(
            transactionId: $response['id'],
            creationDate: (new DateTimeImmutable)->setTimestamp((int)$response['created']),
            amount: bcdiv($response['amount'], 100, 2),
            currency: $response['currency'],
            cardBin: $response['card']['first6']
        );
    }
}