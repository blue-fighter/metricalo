<?php

namespace App\Infrastructure\Integrations\Shift4;

use App\Infrastructure\Integrations\Shift4\Exception\ChargeException;
use App\Infrastructure\Integrations\Shift4\Exception\Shift4ResponseException;
use App\Infrastructure\Integrations\Shift4\Request\Shift4RequestInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final readonly class Shift4Client
{
    public function __construct(
        private string $url,
        private string $apiKey,
        private HttpClientInterface $client,
    ) {}

    public function sendRequest(
        string $method,
        string $url,
        Shift4RequestInterface $request,
    ): array
    {
        $url = sprintf('%s/%s', $this->url, $url);
        $t1 = $request->getBody();
        try {
            $response = $this->client->request(
                $method,
                $url,
                [
                    'auth_basic' => sprintf('%s:', $this->apiKey),
                    'body' => $request->getBody(),
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (TransportExceptionInterface $e) {
            throw new ChargeException("Invalid request to api.shift4.com");
        } catch (HttpExceptionInterface $e) {
            throw new Shift4ResponseException("api.shift4.com error response");
        }
    }
}