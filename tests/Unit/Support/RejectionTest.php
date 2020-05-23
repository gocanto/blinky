<?php

declare(strict_types=1);

namespace Blinky\Tests\Unit\Support;

use Blinky\Support\Rejection;
use PHPUnit\Framework\TestCase;

class RejectionTest extends TestCase
{
    /**
     * @test
     */
    public function itProperlyCreatesRejections(): void
    {
        $rejection = new Rejection('error');

        $this->assertSame('error', $rejection->getMessage());
        $this->assertSame(Rejection::DEFAULT_ERROR_CODE, $rejection->getCode());
    }
}
