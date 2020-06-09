<?php

declare(strict_types=1);

namespace Blinky\Tests\Integration;

use Blinky\Mailgun\Client;
use Blinky\Mailgun\Credentials;
use Gocanto\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class MailgunTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $credentials = Credentials::live();
        $credentials->setUsername('api');
        $credentials->setApiKey('live-key');

        $this->client = new Client($credentials, new HttpClient());
    }

    /**
     * @test
     */
    public function itProperlyValidatesGivenAddresses(): void
    {
        $response = $this->client->verify('gustavoocanto@gmail.com');

        $this->assertTrue($response->isValid());
        $this->assertNotEmpty($response->toArray());

        $data = $response->toArray();
        $this->assertSame('gustavoocanto@gmail.com', $data['address']);
        $this->assertSame('deliverable', $data['result']);
        $this->assertSame('low', $data['risk']);
        $this->assertFalse($data['is_disposable_address']);
        $this->assertFalse($data['is_role_address']);
        $this->assertCount(0, $data['reason']);
    }

    /**
     * @test
     */
    public function itReturnSuggestionIfAny(): void
    {
        $response = $this->client->verify('gus@gus.com');

        $this->assertFalse($response->isValid());
        $this->assertNotEmpty($response->toArray());

        $data = $response->toArray();
        $this->assertSame('gus@gus.com', $data['address']);
        $this->assertSame('unknown', $data['result']);
        $this->assertSame('unknown', $data['risk']);
        $this->assertFalse($data['is_disposable_address']);
        $this->assertFalse($data['is_role_address']);
        $this->assertCount(1, $data['reason']);

        $this->assertTrue($response->hasSuggestion());
        $this->assertNotEmpty($response->getSuggestion());
    }
}
