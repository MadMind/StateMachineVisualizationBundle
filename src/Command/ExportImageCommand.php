<?php

namespace MadMind\StateMachineVisualizationBundle\Command;

use MadMind\StateMachineVisualizationBundle\Service\DotGeneratorInterface;
use MadMind\StateMachineVisualizationBundle\Service\ImageGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportImageCommand extends Command
{
    protected $dotGenerator;
    protected $imageGenerator;
    protected $defaultLayout;
    protected $defaultNodeShape;

    public function __construct(
        DotGeneratorInterface $dotGenerator,
        ImageGeneratorInterface $imageGenerator,
        $defaultLayout,
        $defaultNodeShape
    ) {
        $this->dotGenerator = $dotGenerator;
        $this->imageGenerator = $imageGenerator;
        $this->defaultLayout = $defaultLayout;
        $this->defaultNodeShape = $defaultNodeShape;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('smv:image')
            ->setDescription('Export state machine visualisation image')
            ->addArgument('format', InputArgument::REQUIRED, 'Output image format: png, jpg, gif, svg')
            ->addArgument('state_machine_name', InputArgument::REQUIRED, 'State machine name to export')
            ->addOption('layout', null, InputOption::VALUE_OPTIONAL, 'Dot layout')
            ->addOption('node_shape', null, InputOption::VALUE_OPTIONAL, 'Dot node shape');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $format = $input->getArgument('format');
        $machineName = $input->getArgument('state_machine_name');
        $layout = strtoupper($input->getOption('layout') ?: $this->defaultLayout);
        $nodeShape = strtolower($input->getOption('node_shape') ?: $this->defaultNodeShape);

        $dotFile = $this->dotGenerator->generate($machineName, $layout, $nodeShape);
        $outputImage = $this->imageGenerator->render($format, $dotFile);

        $outputFile = sprintf('smv_%s.%s', $machineName, $format);
        copy($outputImage, $outputFile);

        $output->writeln($outputFile.' exported');

        return 0;
    }
}
