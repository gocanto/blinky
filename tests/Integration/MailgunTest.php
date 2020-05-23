<?php

declare(strict_types=1);

namespace Blinky\Tests\Integration;

use Blinky\Mailgun\Client;
use Blinky\Mailgun\Credentials;
use Gocanto\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class MailgunTest extends TestCase
{
    /**
     * @test
     */
    public function itProperlyValidatesGivenAddressesAgainstMailgun(): void
    {
        $credentials = Credentials::live();
        $credentials->setUsername('api');
        $credentials->setApiKey('production-key');

        $client = new Client($credentials, new HttpClient());
        $response = $client->verify('gustavoocanto@gmail.com');

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
}
