<?php

declare(strict_types=1);

namespace Blinky\Tests\Unit\Mailgun;

use Blinky\Environment;
use Blinky\Mailgun\Credentials;
use PHPUnit\Framework\TestCase;

class CredentialsTest extends TestCase
{
    /**
     * @test
     */
    public function itProperlyCreatesTestingCredentials(): void
    {
        $credentials = Credentials::test();

        $credentials->setUsername('api');
        $credentials->setApiKey('key-foo');

        $this->assertTrue($credentials->isTest());
        $this->assertSame('api', $credentials->getUsername());
        $this->assertSame('key-foo', $credentials->getApiKey());
        $this->assertSame(Environment::TEST, $credentials->getEnvironment());
    }

    /**
     * @test
     */
    public function itProperlyCreatesLiveCredentials(): void
    {
        $credentials = Credentials::live();

        $credentials->setUsername('api');
        $credentials->setApiKey('key-foo');

        $this->assertFalse($credentials->isTest());
        $this->assertSame('api', $credentials->getUsername());
        $this->assertSame('key-foo', $credentials->getApiKey());
        $this->assertSame(Environment::LIVE, $credentials->getEnvironment());
    }
}
