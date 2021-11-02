<?php

namespace MadMind\StateMachineVisualizationBundle\Service;

interface DotGeneratorInterface
{
    /**
     * @param string $stateMachineName
     * @param string $layout
     * @param string $nodeShape
     *
     * @return string
     */
    public function generate($stateMachineName, $layout, $nodeShape);
}
