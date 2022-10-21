<?php
/**
 * This file is a part of small-logger-bundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SebkSmallLoggerExtension extends Extension
{

    /**
     * Load bundle
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // Read configuration
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        //$container->setParameter('small_logger.shortcuts', $config['shortcuts']);

        // Load service.yml
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        // Populate container with configuration
        $container->setParameter("sebk_small_logger", $config);
    }

}