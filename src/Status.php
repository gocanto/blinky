<?php

declare(strict_types=1);

namespace Blinky;

final class Status
{
    private bool $valid;
    private array $payload;
    private ?string $suggestion;

    private function __construct(array $payload)
    {
        $this->payload = $payload;
        $this->suggestion = null;
    }

    public static function valid(array $payload): self
    {
        $status = new Status($payload);
        $status->valid = true;

        return $status;
    }

    public static function invalid(array $payload): self
    {
        $status = new Status($payload);

        $status->valid = false;

        return $status;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function hasSuggestion(): bool
    {
        return $this->suggestion !== null;
    }

    public function getSuggestion(): ?string
    {
        return $this->suggestion;
    }

    public function setSuggestion(?string $suggestion): void
    {
        $this->suggestion = $suggestion;
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
