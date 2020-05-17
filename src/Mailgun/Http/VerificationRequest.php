<?php

declare(strict_types=1);

namespace Blinky\Mailgun\Http;

class VerificationRequest
{
    public const API_VERSION = 'v4';
    public const MAX_RETRIES = 5;

    private string $address;
    private int $retries = self::MAX_RETRIES;
    private string $version = self::API_VERSION;

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

    /**
     * @return int
     */
    public function getRetries(): int
    {
        return $this->retries;
    }

    /**
     * @param int $retries
     */
    public function setRetries(int $retries): void
    {
        $this->retries = $retries;
    }

    public function getUrl(): string
    {
        return "https://api.mailgun.net/{$this->version}/address/validate";
    }
}
