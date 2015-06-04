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
            ->scalarNode('dot')
            ->defaultTrue('/usr/bin/dot')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
