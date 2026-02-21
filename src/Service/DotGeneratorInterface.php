<?php

namespace MadMind\StateMachineVisualizationBundle\Service;

interface DotGeneratorInterface
{
    public function generate(string $stateMachineName, string $layout, string $nodeShape): string;
}
