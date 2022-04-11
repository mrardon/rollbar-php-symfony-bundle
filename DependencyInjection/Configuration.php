<?php

namespace Rollbar\Symfony\RollbarBundle\DependencyInjection;

use Rollbar\Config;
use Rollbar\Defaults;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @link https://rollbar.com/docs/notifier/rollbar-php/#configuration-reference
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(RollbarExtension::ALIAS);
        $rollbarConfigNode = $treeBuilder->getRootNode();

        $rollbarConfigNodeChildren = $rollbarConfigNode->children();

        $configOptions = Config::listOptions();
        $rollbarDefaults = Defaults::get();

        foreach ($configOptions as $option) {
            $method = match ($option) {
                'branch' => 'gitBranch',
                default => $option,
            };

            try {
                $default = $rollbarDefaults->fromSnakeCase($method);
            } catch (\Exception $e) {
                $default = null;
            }

            if (is_array($default)) {
                $rollbarConfigNodeChildren
                    ->arrayNode($option)
                        ->scalarPrototype()->end()
                        ->defaultValue($default)
                    ->end();
            } else {
                $rollbarConfigNodeChildren
                    ->scalarNode($option)
                        ->defaultValue($default)
                    ->end();
            }
        }

        return $treeBuilder;
    }
}
