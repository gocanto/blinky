<?php

declare(strict_types=1);

namespace Blinky\Contracts;

interface VerificationRequest
{
    public function getUrl(): string;
    public function getRetries(): int;
    public function getAddress(): string;
}
