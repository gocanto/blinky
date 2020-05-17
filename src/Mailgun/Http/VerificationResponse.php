<?php

declare(strict_types=1);

namespace Blinky\Mailgun\Http;

use Blinky\Verification;

class VerificationResponse implements Verification
{
    public const AUTHORISED = 'deliverable';

    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function isValid(): bool
    {
        return
            count($this->getReasons()) === 0
            && mb_strtolower($this->getResult()) === self::AUTHORISED;
    }

    public function getSuggestion(): ?string
    {
        return $this->isValid() ? null : $this->payload['did_you_mean'];
    }

    public function getReasons(): array
    {
        return $this->payload['reason'];
    }

    public function getResult(): string
    {
        return $this->payload['result'];
    }

    public function getAddress(): string
    {
        return $this->payload['address'];
    }

    public function getRisk(): string
    {
        return $this->payload['risk'];
    }

    public function isDisposableAddress(): bool
    {
        return $this->payload['is_disposable_address'];
    }

    public function isRoleAddress(): bool
    {
        return $this->payload['is_role_address'];
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
