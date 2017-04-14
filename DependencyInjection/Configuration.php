<?php

namespace MadMind\StateMachineVisualizationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('state_machine_visualization');

        $rootNode
            ->children()
            ->scalarNode('dot')->defaultValue('/usr/bin/dot')->end()
            ->scalarNode('layout')->defaultValue('LR')->end()
            ->scalarNode('node_shape')->defaultValue('circle')->end()
            ->end();

        return $treeBuilder;
    }
}
