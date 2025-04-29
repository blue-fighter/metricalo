<?php

namespace App\Infrastructure\Integrations\ACI;

use App\Infrastructure\Integrations\ACI\Exception\ACIResponseException;
use App\Infrastructure\Integrations\ACI\Exception\PerformDebitPaymentException;
use App\Infrastructure\Integrations\ACI\Request\AciRequestInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final readonly class AciClient
{
    public function __construct(
        private string $url,
        private string $auth_key,
        private HttpClientInterface $client,
    ) {}

    /**
     * @throws ACIResponseException
     * @throws PerformDebitPaymentException
     */
    public function sendRequest(
        string $method,
        string $url,
        AciRequestInterface $request,
    ): array
    {
        $url = sprintf('%s/%s', $this->url, $url);
        try {
            $response = $this->client->request(
                $method,
                $url,
                [
                    'auth_bearer' => $this->auth_key,
                    'body' => $request->getBody(),
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (TransportExceptionInterface $e) {
            throw new PerformDebitPaymentException("Invalid request to eu-test.oppwa.com");
        } catch (HttpExceptionInterface $e) {
            throw new ACIResponseException("eu-test.oppwa.com error response");
        }
    }
}