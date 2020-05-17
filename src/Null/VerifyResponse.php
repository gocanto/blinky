<?php

declare(strict_types=1);

namespace Blinky\Null;

use Blinky\Contracts\VerificationResponse;

class VerifyResponse implements VerificationResponse
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function toArray(): array
    {
        return $this->payload;
    }

    public function getSuggestion(): ?string
    {
        return null;
    }
}
