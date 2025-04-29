<?php

namespace App\Tests\Functional;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChargeEndpointTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccessAci(): void
    {
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request(
            method: 'POST',
            uri: '/purchase/aci',
            content: json_encode([
                "amount" => 10000,
                "currency" =>  "USD",
                "cardNumber" =>  "5228600509542835",
                "cardExpYear" => 29,
                "cardExpMonth" =>  12,
                "cardCVV" =>  123
            ])
        );
        $t1 = $crawler;
        $this->assertResponseIsSuccessful();

    }
}