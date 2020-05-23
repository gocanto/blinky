<?php

declare(strict_types=1);

namespace Blinky\Tests\Unit;

use Blinky\BlinkyException;
use PHPUnit\Framework\TestCase;

class BlinkyExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function itProperlyPopulateRejectionObjects(): void
    {
        $exception = BlinkyException::create('error', 404);

        $this->assertSame('error', $exception->toString());
        $this->assertSame(404, $exception->getRejection()->getCode());
        $this->assertSame('error', $exception->getRejection()->getMessage());
    }

    /**
     * @test
     */
    public function itBuildsItselfWithoutRejectionObjects(): void
    {
        $exception = new BlinkyException('error');

        $this->assertSame('error', $exception->toString());
        $this->assertNull($exception->getRejection());
    }
}
