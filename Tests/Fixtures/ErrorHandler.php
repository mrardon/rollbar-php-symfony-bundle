<?php

namespace Tests\Fixtures;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class ErrorHandler extends AbstractProcessingHandler
{
    protected static ErrorHandler $instance;

    /**
     * @var callable
     */
    protected $assert;

    public static function getInstance(): ErrorHandler
    {
        if (empty(static::$instance)) {
            static::$instance = new self(Logger::DEBUG);
        }

        return static::$instance;
    }

    public function setAssert(callable $assert = null): void
    {
        $this->assert = $assert;
    }

    /**
     * Writes the record down to the log of the implementing handler
     */
    protected function write(array $record): void
    {
        $dummy = static function () {
        };

        $closure = empty($this->assert) ? $dummy : $this->assert;
        $closure($record);
    }
}
