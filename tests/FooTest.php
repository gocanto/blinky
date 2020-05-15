<?php

declare(strict_types=1);

namespace Blinky\Tests;

use Blinky\Http\VerifyRequest;
use Blinky\Mailgun\Client;
use Blinky\Mailgun\Credentials;
use Gocanto\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    /**
     * @test
     */
    public function testingThisCode(): void
    {
        $credentials = Credentials::live();
        $credentials->setApiKey('foo');

        $client = new Client($credentials, new HttpClient());
        $response = $client->verify(new VerifyRequest());

        $foo = 1;
    }
}
