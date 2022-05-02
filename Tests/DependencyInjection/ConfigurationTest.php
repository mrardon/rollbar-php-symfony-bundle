<?php

namespace Rollbar\Symfony\RollbarBundle\Tests\DependencyInjection;

use Rollbar\Config;
use Rollbar\Defaults;
use Rollbar\Symfony\RollbarBundle\DependencyInjection\RollbarExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigurationTest extends KernelTestCase
{
    public function testParameters(): void
    {
        static::bootKernel();
        $container = static::$container ?? static::$kernel->getContainer();

        $config = $container->getParameter(RollbarExtension::ALIAS . '.config');

        $configOptions = Config::listOptions();
        $rollbarDefaults = Defaults::get();

        $defaults = [];
        foreach ($configOptions as $option) {
            // Handle the "branch" exception
            $method = match ($option) {
                "branch" => "gitBranch",
                default => $option,
            };

            try {
                $default = $rollbarDefaults->fromSnakeCase($method);
            } catch (\Exception $e) {
                $default = null;
            }

            $defaults[$option] = $default;
        }

        $this->assertNotEmpty($config);
        $this->assertEquals($defaults, $config);
    }
}
