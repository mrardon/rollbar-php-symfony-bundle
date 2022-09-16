<?php

namespace Rollbar\Symfony\RollbarBundle\Tests\Payload;

use Rollbar\Symfony\RollbarBundle\Payload\TraceItem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TraceItemTest extends KernelTestCase
{
    public function testInvoke(): void
    {
        $msg = 'Text exception - ' . md5(microtime());
        $ex  = new \Exception($msg, 7);

        $item = new TraceItem();
        $data = $item($ex);

        $this->assertNotEmpty($data['exception']);
        $this->assertNotEmpty($data['frames']);

        $exception = $data['exception'];
        $this->assertEquals(get_class($ex), $exception['class']);
        $this->assertStringContainsString($msg, $exception['message']);

        $this->assertGreaterThan(1, count($data['frames']));

        $frame = $data['frames'][0];
        $this->assertArrayHasKey('filename', $frame);
        $this->assertArrayHasKey('lineno', $frame);
        $this->assertArrayHasKey('class_name', $frame);
    }
}
