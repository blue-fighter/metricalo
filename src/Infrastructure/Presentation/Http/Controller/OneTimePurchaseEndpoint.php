<?php

namespace App\Infrastructure\Presentation\Http\Controller;

use App\Application\Factory\PurchaseRequestFactoryInterface;
use App\Application\UseCase\ExecuteChargeUseCase;
use App\Infrastructure\Presentation\Http\Response\ChargeResponse;
use App\Infrastructure\Presentation\Request\OneTimePurchaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class OneTimePurchaseEndpoint extends AbstractController
{
    public function __construct(
        private readonly ExecuteChargeUseCase $useCase,
        private readonly PurchaseRequestFactoryInterface $chargeRequestFactory,
    ) {}

    #[Route(
        path: 'purchase/{gateway}',
        methods: ['POST'],
        format: 'json',
        requirements: ['gateway' => '\S+'],
    )
    ]
    public function charge(
        #[MapRequestPayload] OneTimePurchaseRequest $request,
        string $gateway,
    ): JsonResponse
    {
        $purchaseRequest = $this->chargeRequestFactory->create(
            expireMonth: $request->getCardExpMonth(),
            expireYear: $request->getCardExpYear(),
            amount: $request->getAmount(),
            currency: $request->getCurrency(),
            number: $request->getCardNumber(),
            cvv: $request->getCardCVV(),
        );

        $result = $this->useCase->execute($gateway, $purchaseRequest);

        return new JsonResponse(
            data: new ChargeResponse(
                transactionId: $result->getTransactionId(),
                dateOfCreating: $result->getCreationDate(),
                amount: $result->getAmount(),
                currency: $result->getCurrency(),
                cardBin: $result->getCardBin(),
            ),
            status: Response::HTTP_OK,
            json: true,
        );
    }
}