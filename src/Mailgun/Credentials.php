<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

use Blinky\Environment;

final class Credentials
{
    private string $apiKey;
    private string $environment;

    private function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    public static function test(): self
    {
        return new static(Environment::TEST);
    }

    public static function live(): self
    {
        return new static(Environment::LIVE);
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function isTest(): bool
    {
        return $this->environment === Environment::TEST;
    }
}
