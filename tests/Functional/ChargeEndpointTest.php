<?php

namespace App\Tests\Functional;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChargeEndpointTest extends WebTestCase
{
    public function setUp(): void
    {
        // parent::setUp();
    }

    public function testSuccess(): void
    {
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request(
            'POST',
            '/charge',
        );
        $t1 = $crawler;
        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();

    }
}