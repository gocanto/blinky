<?php

declare(strict_types=1);

namespace Blinky\Mailgun\Http;

class VerificationRequest
{
    public const API_VERSION = 'v4';

    private string $version = self::API_VERSION;
    private string $address;

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getUrl(): string
    {
        return "https://api.mailgun.net/{$this->version}/address/validate";
    }
}
