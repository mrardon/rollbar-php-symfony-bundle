<?php

namespace Rollbar\Symfony\RollbarBundle\Payload;

use JetBrains\PhpStorm\ArrayShape;

class ErrorItem
{
    /**
     * List of map for human readable constants
     * @link http://php.net/manual/en/errorfunc.constants.php
     */
    public static array $map = [
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_STRICT            => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
    ];

    #[ArrayShape(['exception' => "array", 'frames' => "array[]"])]
    public function __invoke(int $code, string $message, string $file, int $line): array
    {
        return [
            'exception' => [
                'class'   => $this->mapError($code),
                'message' => implode(' ', [
                    "'\\" . $this->mapError($code) . "'",
                    'with message',
                    "'" . $message . "'",
                    'occurred in file',
                    "'" . $file . "'",
                    'line',
                    "'" . $line . "'",
                ]),
            ],
            'frames'    => [
                [
                    'filename' => $file,
                    'lineno'   => $line,
                ],
            ],
        ];
    }

    /**
     * Map error code to human format
     */
    protected function mapError(mixed $code): string
    {
        $code = (int) $code;

        return !empty(static::$map[$code]) ? static::$map[$code] : 'E_UNDEFINED';
    }
}
