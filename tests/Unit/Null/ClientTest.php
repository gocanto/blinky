<?php

declare(strict_types=1);

namespace Blinky\Tests\Unit\Null;

use Blinky\Null\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function itProperlyValidatesEmails(): void
    {
        $client = new Client();
        $response = $client->verify('gustavoocanto@gmail.com');

        $this->assertTrue($response->isValid());
        $this->assertSame('gustavoocanto@gmail.com', $response->toArray()['address']);
    }
}
