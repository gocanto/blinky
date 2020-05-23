<?php

declare(strict_types=1);

namespace Blinky\Mailgun;

final class Config
{
    public const MAX_RETRY = 5;
    public const VALID_STATUS = 'deliverable';
    public const URL = 'https://api.mailgun.net/v4/address/validate';
}
