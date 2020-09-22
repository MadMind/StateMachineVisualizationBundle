<?php

namespace MadMind\StateMachineVisualizationBundle\Service;

use MadMind\StateMachineVisualizationBundle\Exception\DotException;

class StateMachineDotGenerator implements DotGeneratorInterface
{
    protected $stateMachines;
    protected $cacheDir;

    public function __construct(array $stateMachines, $cacheDir)
    {
        $this->stateMachines = $stateMachines;
        $this->cacheDir = $cacheDir;
    }

    public function generate($stateMachineName, $layout, $nodeShape)
    {
        if (empty($this->stateMachines[$stateMachineName])) {
            throw new DotException(sprintf("State machine '%s' not found", $stateMachineName));
        }
        $machine = $this->stateMachines[$stateMachineName];

        $hash = md5(serialize($machine));
        $dotFile = sprintf('%s/smv_%s_%s.dot', $this->cacheDir, $stateMachineName, $hash);
        if (file_exists($dotFile)) {
            return $dotFile;
        }

        // Build dot file content.
        $result = [];
        $result[] = 'digraph finite_state_machine {';
        $result[] = "rankdir=$layout;";
        $result[] = 'node [shape = point]; _start_'; // Input node

        // Use first value from 'states' as start.
        $start = $machine['states'][0];
        $result[] = "node [shape = $nodeShape];";
        $result[] = '_start_ -> '.$start.';';

        foreach ($machine['transitions'] as $name => $transition) {
            foreach ($transition['from'] as $from) {
                $result[] = $from.' -> '.$transition['to'].'[ label = "'.$name.'" ];';
            }
        }
        $result[] = '}';

        $result = implode(PHP_EOL, $result);
        file_put_contents($dotFile, $result);

        return $dotFile;
    }
}
