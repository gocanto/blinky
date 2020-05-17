<?php

declare(strict_types=1);

namespace Blinky;

interface Verification
{
    public function isValid(): bool;

    public function getSuggestion(): ?string;

    public function toArray(): array;
}
