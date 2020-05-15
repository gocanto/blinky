<?php

declare(strict_types=1);

namespace Blinky;

use Blinky\Support\Rejection;
use Exception;
use Throwable;

class BlinkyException extends Exception
{
    private Rejection $rejection;

    public static function create(string $message, ?int $error = null, ?Throwable $previous = null): self
    {
        $exception = new static($message, $error, $previous);

        $exception->rejection = new Rejection($message, $error);

        return $exception;
    }

    public static function fromThrowable(Throwable $previous, string $message = null, int $code = null): self
    {
        return static::create($message ?? $previous->getMessage(), $code, $previous);
    }

    /**
     * @return Rejection
     */
    public function getRejection(): Rejection
    {
        return $this->rejection;
    }

    public function toString(): string
    {
        $rejection = $this->rejection;

        if ($rejection === null) {
            $rejection = new Rejection($this->getMessage(), $this->getCode());
        }

        $message = $this->getMessage();
        $message .= PHP_EOL;

        return $message . ' ' . $rejection->getMessage();
    }
}
