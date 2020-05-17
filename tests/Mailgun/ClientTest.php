<?php

declare(strict_types=1);

namespace Blinky\Tests\Mailgun;

use Blinky\BlinkyException;
use Blinky\Mailgun\Client;
use Blinky\Mailgun\Credentials;
use Blinky\Mailgun\Http\VerificationRequest;
use Blinky\Mailgun\Http\VerificationResponse;
use Gocanto\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     * @throws BlinkyException
     */
    public function itProperlyValidatesGivenAddresses(): void
    {
        $credentials = Credentials::live();
        $credentials->setUsername('api');
        $credentials->setApiKey('key-');

        $request = new VerificationRequest();
        $request->setAddress('gustavoocanto@gmail.com');

        $client = new Client($credentials, new HttpClient());
        $response = $client->verify($request);

        $this->assertTrue($response->isValid());
        $this->assertNull($response->getSuggestion());
        $this->assertEmpty($response->getReasons());
        $this->assertSame($response->getResult(), VerificationResponse::AUTHORISED);
        $this->assertSame($response->getAddress(), 'gustavoocanto@gmail.com');
        $this->assertNotEmpty($response->getRisk());
        $this->assertFalse($response->isDisposableAddress());
        $this->assertFalse($response->isRoleAddress());
        $this->assertNotEmpty($response->toArray());
    }
}
