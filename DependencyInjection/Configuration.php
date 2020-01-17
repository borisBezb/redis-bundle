<?php

namespace Bezb\RedisBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Bezb\RedisBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bezb_redis');

        $treeBuilder->getRootNode()
            ->children()
                ->enumNode('driver')
                    ->values(['predis', 'redis'])
                    ->defaultValue('predis')
                ->end()
                ->scalarNode('default')
                    ->defaultValue('default')
                ->end()
                ->arrayNode('connections')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('host')
                                ->defaultValue('127.0.0.1')
                            ->end()
                            ->scalarNode('password')
                                ->defaultValue('')
                            ->end()
                            ->scalarNode('port')
                                ->defaultValue('6379')
                            ->end()
                            ->scalarNode('database')
                                ->defaultValue('0')
                            ->end()
                            ->scalarNode('timeout')
                                ->defaultValue(0)
                            ->end()
                            ->scalarNode('read_timeout')
                                ->defaultValue(0)
                            ->end()
                            ->booleanNode('persistent')
                                ->defaultValue(false)
                            ->end()
                            ->enumNode('serializer')
                                ->values(['none', 'php', 'igbinary'])
                                ->defaultValue('php')
                            ->end()
                            ->scalarNode('prefix')
                                ->defaultValue('')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}