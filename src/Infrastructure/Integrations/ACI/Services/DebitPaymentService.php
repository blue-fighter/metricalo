<?php

namespace App\Infrastructure\Integrations\ACI\Services;

use App\Application\Contracts\PurchaseRequest;
use App\Application\Contracts\PurchaseResponse;
use App\Application\Contracts\PurchaseServiceInterface;
use App\Infrastructure\Integrations\ACI\AciClient;
use App\Infrastructure\Integrations\ACI\Factory\DebitRequestFactoryInterface;
use DateTimeImmutable;
final readonly class DebitPaymentService implements PurchaseServiceInterface
{
    const string ACTION_URL = 'v1/payments';

    public function __construct(
        private AciClient $client,
        private DebitRequestFactoryInterface $debitRequestFactory
    ) {}


    public function purchase(PurchaseRequest $request): PurchaseResponse
    {
        $request = $this->debitRequestFactory->create($request);
        $response = $this->client->sendRequest(
            'POST',
            self::ACTION_URL,
            $request,
        );
        return new PurchaseResponse(
            transactionId: $response['id'],
            creationDate: new DateTimeImmutable($response['timestamp']),
            amount: $response['amount'],
            currency: $response['currency'],
            cardBin: $response['card']['bin']
        );
    }
}