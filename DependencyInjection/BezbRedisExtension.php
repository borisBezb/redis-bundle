<?php

namespace Bezb\RedisBundle\DependencyInjection;

use Bezb\RedisBundle\RedisManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class BezbRedisExtension
 * @package Bezb\RedisBundle\DependencyInjection
 */
class BezbRedisExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $manager = $container->getDefinition(RedisManager::class);

        $manager->addArgument($config['driver']);
        $manager->addArgument($config['connections']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}