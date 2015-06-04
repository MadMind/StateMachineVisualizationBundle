<?php

namespace MadMind\StateMachineVisualizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function imageAction($machineName, $format)
    {
        // Output image mime types.
        $mimeTypes = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
        ];

        if (empty($mimeTypes[$format])) {
            throw new \Exception(sprintf("Format '%s' is not supported", $format));
        }

        // Read 'winzou_state_machine' config.
        $config = $this->container->getParameter('sm.configs');

        if (empty($config[$machineName])) {
            throw new \Exception(sprintf("State machine '%s' not found", $machineName));
        }

        // Temporary files.
        $dotFile = tempnam(sys_get_temp_dir(), 'smv');
        $outputImage = tempnam(sys_get_temp_dir(), 'smv');

        // Build dot file content.
        $result = [];
        $result[] = 'digraph finite_state_machine {';
        $result[] = 'rankdir=LR;'; //TODO: Allow change of layout from config and as GET parameter.
        $result[] = 'node [shape = point ]; _start_'; // Input node

        // Use first value from 'states' as start.
        // TODO: Allow changing this in config.
        $start = $config[$machineName]['states'][0];
        // $result[] = 'node [shape = doublecircle]; ' . $start . ';'; // Double circle for start.
        $result[] = 'node [shape = circle];'; // Default nodes
        $result[] = '_start_ -> ' . $start . ';'; // Input node -> starting node.

        foreach ($config[$machineName]['transitions'] as $name => $transition) {
            foreach ($transition['from'] as $from) {
                // TODO: Add customization.
                $result[] = $from . ' -> ' . $transition['to'] . '[ label = "' . $name . '" ];';
            }
        }

        $result[] = '}';

        $result = implode(PHP_EOL, $result);

        // Save dot file for input.
        file_put_contents($dotFile, $result);

        // Dot command.
        $cmd = sprintf(
            "%s -T%s -o %s %s",
            escapeshellarg($this->container->getParameter('state_machine_visualization.dot')), // Executable
            $format,
            escapeshellarg($outputImage), // Output file
            escapeshellarg($dotFile) // Input file
        );
        // TODO: Check if executable exists and can run.

        exec($cmd);

        $response = new Response(file_get_contents($outputImage), 200);
        $response->headers->set('Content-Type', $mimeTypes[$format]);

        // Remove temporary files.
        unlink($outputImage);
        unlink($dotFile);

        return $response;
    }
}
