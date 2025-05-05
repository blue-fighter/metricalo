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
        $client->jsonRequest(
            method: 'POST',
            uri: '/purchase/aci',
            parameters: [
                "amount" => 10000,
                "currency" =>  "USD",
                "cardNumber" =>  "5228600509542835",
                "cardExpYear" => 29,
                "cardExpMonth" =>  12,
                "cardCVV" =>  123
            ],
        );
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($response['transaction_id']);
        $this->assertEquals(date('Y-m-d'), $response['date_of_creating']);
        $this->assertEquals('100.00', $response['amount']);
        $this->assertEquals('EUR', $response['currency']);
        $this->assertEquals('420000', $response['card_bin']);
        $this->assertResponseIsSuccessful();
    }

    public function testSuccessShft4(): void
    {
        $client = static::createClient();

        // Request a specific page
        $client->jsonRequest(
            method: 'POST',
            uri: '/purchase/shift4',
            parameters: [
                "amount" => 10000,
                "currency" =>  "USD",
                "cardNumber" =>  "5228600509542835",
                "cardExpYear" => 29,
                "cardExpMonth" =>  12,
                "cardCVV" =>  123
            ],
        );
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($response['transaction_id']);
        $this->assertEquals(date('Y-m-d'), $response['date_of_creating']);
        $this->assertEquals('100.00', $response['amount']);
        $this->assertEquals('USD', $response['currency']);
        $this->assertEquals('424242', $response['card_bin']);
        $this->assertResponseIsSuccessful();
    }
}