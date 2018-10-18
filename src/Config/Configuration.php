<?php

namespace Kyoushu\Conjuration\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('conjuration');

        $rootNode
            ->children()
                ->scalarNode('public_dir')->defaultValue('public')->end()
                ->scalarNode('cache_dir')->defaultValue('var/cache')->end()
                ->scalarNode('log_dir')->defaultValue('var/logs')->end()
                ->arrayNode('model')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')->isRequired()->end()
                            ->scalarNode('label')->isRequired()->end()
                            ->scalarNode('url_prefix')->defaultNull()->end()
                            ->booleanNode('single')->defaultFalse()->end()
                            ->arrayNode('fields')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('name')->isRequired()->end()
                                        ->scalarNode('label')->isRequired()->end()
                                        ->scalarNode('type')->isRequired()->end()
                                        ->booleanNode('required')->defaultFalse()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

}