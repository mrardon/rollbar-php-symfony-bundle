<?php

namespace Rollbar\Symfony\RollbarBundle\Tests\Payload;

use Rollbar\Symfony\RollbarBundle\Payload\TraceChain;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TraceChainTest extends KernelTestCase
{
    public function testInvoke(): void
    {
        $previous = new \Exception('Exception', 1);
        $previous = new \Exception('Exception', 2, $previous);
        $ex       = new \Exception('Exception', 3, $previous);

        $trace = new TraceChain();
        $chain = $trace($ex);

        $this->assertCount(3, $chain);

        foreach ($chain as $item) {
            $this->assertArrayHasKey('exception', $item);
            $this->assertArrayHasKey('frames', $item);
        }
    }
}
