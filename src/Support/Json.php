<?php

declare(strict_types=1);

namespace Blinky\Support;

use Blinky\BlinkyException;
use Throwable;

class Json
{
    /**
     * @throws BlinkyException
     */
    public static function decode(string $content, $assoc = true, int $depth = 512): array
    {
        try {
            $decoded = json_decode($content, $assoc, $depth, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw BlinkyException::fromThrowable($e);
        }

        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        throw BlinkyException::fromRejection(self::resolveRejection());
    }

    private static function resolveRejection(): Rejection
    {
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            case JSON_ERROR_UTF16:
                $error = 'Malformed UTF-16 characters, possibly incorrectly encoded';
                break;
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded';
                break;
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'Value of a type that cannot be encoded was given';
                break;
            case JSON_ERROR_INVALID_PROPERTY_NAME:
                $error = 'A property name that cannot be encoded was given';
                break;
            default:
                $error = 'Unknown error';
        }

        return new Rejection($error);
    }
}
