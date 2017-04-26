<?php
namespace Tests\SymfonyRollbarBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

/**
 * Class AbstractListenerTest
 * @package Tests\SymfonyRollbarBundle\EventListener
 */
class AbstractListenerTest extends KernelTestCase
{
    public function setUp()
    {
        parent::setUp();

        static::bootKernel();
    }

    public function testListeners()
    {
        $container = static::$kernel->getContainer();
        /**
         * @var TraceableEventDispatcher $eventDispatcher
         */
        $eventDispatcher = $container->get('event_dispatcher');
        $listeners = $eventDispatcher->getListeners('kernel.exception');

        $expected = [
            \SymfonyRollbarBundle\EventListener\AbstractListener::class,
            \Symfony\Component\HttpKernel\EventListener\ExceptionListener::class,
        ];

        foreach ($listeners as $listener) {
            $ok = $listener[0] instanceof $expected[0] || $listener[0] instanceof $expected[1];
            $this->assertTrue($ok, 'Listeners were not registered');
        }
    }
}