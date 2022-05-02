<?php

namespace Rollbar\Symfony\RollbarBundle\Payload;

class TraceChain
{
    public function __invoke(\Throwable $throwable): array
    {
        $chain = [];
        $item  = new TraceItem();

        while (!empty($throwable)) {
            $chain[] = $item($throwable);
            $throwable = $throwable->getPrevious();
        }

        return $chain;
    }
}
