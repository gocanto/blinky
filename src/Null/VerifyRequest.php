<?php

declare(strict_types=1);

namespace Blinky\Null;

use Blinky\Contracts\VerificationRequest;

class VerifyRequest implements VerificationRequest
{
    private array $attribute;

    public function __construct(array $attribute)
    {
        $this->attribute = $attribute;
    }

    public function getUrl(): string
    {
        return 'http://foo.bar';
    }

    public function getRetries(): int
    {
        return 5;
    }

    public function getAddress(): string
    {
        return 'gustavoocanto@gmail.com';
    }

    public function getAttribute(): array
    {
        return $this->attribute;
    }
}
