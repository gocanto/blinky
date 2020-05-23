<?php

declare(strict_types=1);

namespace Blinky\Tests\Unit;

use Blinky\Status;
use Blinky\Transport;
use Blinky\Verifier;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{
    /**
     * @test
     */
    public function itProperlyValidatesEmails(): void
    {
        $address = 'gustavoocanto@gmail.com';
        $status = Status::valid([
            'address' => $address,
        ]);

        $verifier = Mockery::mock(Verifier::class);
        $verifier->shouldReceive('verify')->once()->with($address)->andReturn($status);

        $transport = new Transport($verifier);
        $response = $transport->verify($address);

        $this->assertTrue($response->isValid());
        $this->assertSame('gustavoocanto@gmail.com', $response->toArray()['address']);
    }
}
