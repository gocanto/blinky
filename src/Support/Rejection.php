<?php

declare(strict_types=1);

namespace Blinky\Support;

final class Rejection
{
    public const DEFAULT_ERROR_CODE = 500;

    private string $message;
    private int $code;

    public function __construct(string $message, ?int $code = null)
    {
        $this->message = $message;
        $this->code = $code ?? self::DEFAULT_ERROR_CODE;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
