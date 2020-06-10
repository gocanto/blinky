<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

final class Config
{
    public const VALID_STATUS = 'deliverable';
    public const URL = 'https://api.mailgun.net/v4/address/validate';
}
