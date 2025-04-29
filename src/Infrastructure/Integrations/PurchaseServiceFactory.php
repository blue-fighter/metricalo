<?php

namespace App\Infrastructure\Integrations;

use App\Application\Contracts\PurchaseServiceInterface;
use App\Application\Factory\PurchaseServiceFactoryInterface;
use App\Infrastructure\Integrations\ACI\AciClient;
use App\Infrastructure\Integrations\ACI\Services\DebitPaymentService;
use App\Infrastructure\Integrations\Shift4\Services\ChargeService;
use App\Infrastructure\Integrations\Shift4\Shift4Client;
use UnhandledMatchError;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

readonly class PurchaseServiceFactory implements PurchaseServiceFactoryInterface
{
    const SHIFT4 = 'shift4';
    const ACI = 'aci';

    public function __construct(
        private ContainerInterface $container
    ) {}

    public function create(string $gateway): PurchaseServiceInterface
    {
        try {
            return match ($gateway) {
                self::SHIFT4 => $this->container->get(ChargeService::class),
                self::ACI => $this->container->get(DebitPaymentService::class),
            };
        } catch (UnhandledMatchError) {
            throw new Exception(sprintf('%s gateway is not supported', $gateway));
        }
    }

}