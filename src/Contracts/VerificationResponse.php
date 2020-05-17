<?php

declare(strict_types=1);

namespace Blinky\Contracts;

interface VerificationResponse
{
    public function isValid(): bool;
    public function toArray(): array;
    public function getSuggestion(): ?string;
}
