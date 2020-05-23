<?php

declare(strict_types=1);

namespace Blinky;

use Blinky\Support\Rejection;
use Exception;
use Throwable;

class BlinkyException extends Exception
{
    private ?Rejection $rejection = null;

    public static function create(
        string $message,
        int $error = Rejection::DEFAULT_ERROR_CODE,
        ?Throwable $previous = null
    ): self {
        $rejection = new Rejection($message, $error);

        $exception = new static(
            $rejection->getMessage(),
            $rejection->getCode(),
            $previous
        );

        $exception->rejection = $rejection;

        return $exception;
    }

    public static function fromThrowable(Throwable $previous): self
    {
        return static::create($previous->getMessage(), (int) $previous->getCode(), $previous);
    }

    public function getRejection(): ?Rejection
    {
        return $this->rejection;
    }

    public function toString(): string
    {
        if ($this->rejection !== null) {
            return $this->rejection->getMessage();
        }

        return $this->getMessage();
    }
}
