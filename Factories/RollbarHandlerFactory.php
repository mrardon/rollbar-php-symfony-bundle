<?php

namespace Rollbar\Symfony\RollbarBundle\Factories;

use Psr\Log\LogLevel;
use Monolog\Handler\RollbarHandler;
use Rollbar\Rollbar;
use Rollbar\Symfony\RollbarBundle\DependencyInjection\RollbarExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RollbarHandlerFactory
{
    public function __construct(ContainerInterface $container)
    {
        $config = $container->getParameter(RollbarExtension::ALIAS . '.config');

        if (isset($_ENV['ROLLBAR_TEST_TOKEN']) && $_ENV['ROLLBAR_TEST_TOKEN']) {
            $config['access_token'] = $_ENV['ROLLBAR_TEST_TOKEN'];
        }

        if (!empty($config['person_fn']) && is_callable($config['person_fn'])) {
            $config['person'] = null;
        } elseif (! empty($config['person_service']) && $container->has($config['person_service'])) {
            $config['person_fn'] = static function () use ($container, $config) {
                try {
                    $service = $container->get($config['person_service']);

                    // call service's __invoke method
                    return $service();
                } catch (\Exception $exception) {
                    // Ignore
                }
            };
        } elseif (empty($config['person'])) {
            $config['person_fn'] = static function () use ($container) {
                try {
                    $token = $container->get('security.token_storage')->getToken();

                    if ($token) {
                        $user = $token->getUser();
                        $serializer = $container->get('serializer');
                        return \json_decode($serializer->serialize($user, 'json'), true, 512, JSON_THROW_ON_ERROR);
                    }
                } catch (\Throwable $exception) {
                    // Ignore
                }
            };
        }

        Rollbar::init($config, false, false, false);
    }

    public function createRollbarHandler(): RollbarHandler
    {
        return new RollbarHandler(Rollbar::logger(), LogLevel::ERROR);
    }
}
