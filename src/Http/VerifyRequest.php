<?php

declare(strict_types=1);

namespace Blinky\Http;

class VerifyRequest
{
    public function getUrl(string $version = 'v4'): string
    {
        return "https://api.mailgun.net/{$version}/address/validate";
    }
}
