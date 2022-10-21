<?php
/**
 * This file is a part of small-logger-bundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Sebk\SmallEventsBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Read configuration
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder|void
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('small_logger');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode("shortcuts")
            ->prototype("scalar")->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}