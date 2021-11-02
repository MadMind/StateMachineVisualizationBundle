<?php

namespace MadMind\StateMachineVisualizationBundle\Command;

use MadMind\StateMachineVisualizationBundle\Service\DotGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportDotCommand extends Command
{
    protected $dotGenerator;
    protected $defaultLayout;
    protected $defaultNodeShape;

    public function __construct(
        DotGeneratorInterface $dotGenerator,
        $defaultLayout,
        $defaultNodeShape
    ) {
        $this->dotGenerator = $dotGenerator;
        $this->defaultLayout = $defaultLayout;
        $this->defaultNodeShape = $defaultNodeShape;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('smv:dot')
            ->setDescription('Export state machine visualisation dot file')
            ->addArgument('state_machine_name', InputArgument::REQUIRED, 'State machine name to export')
            ->addOption('layout', null, InputOption::VALUE_OPTIONAL, 'Dot layout')
            ->addOption('node_shape', null, InputOption::VALUE_OPTIONAL, 'Dot node shape')
            ->addOption('output', null, InputOption::VALUE_OPTIONAL, 'Output file name', 'php://stdout');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $machineName = $input->getArgument('state_machine_name');
        $layout = strtoupper($input->getOption('layout') ?: $this->defaultLayout);
        $nodeShape = strtolower($input->getOption('node_shape') ?: $this->defaultNodeShape);
        $output = $input->getOption('output');

        $dotFile = $this->dotGenerator->generate($machineName, $layout, $nodeShape);

        copy($dotFile, $output);

        return 0;
    }
}
