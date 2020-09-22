<?php

namespace MadMind\StateMachineVisualizationBundle\Controller;

use MadMind\StateMachineVisualizationBundle\Service\DotGeneratorInterface;
use MadMind\StateMachineVisualizationBundle\Service\ImageGeneratorInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
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
    }

    public function imageAction($machineName, $format, Request $request)
    {
        if (!$this->imageGenerator->supports($format)) {
            throw new RuntimeException(sprintf("Format '%s' is not supported", $format));
        }

        $layout = strtoupper($request->query->get('layout', $this->defaultLayout));
        $nodeShape = strtolower($request->query->get('node_shape', $this->defaultNodeShape));

        $dotFile = $this->dotGenerator->generate($machineName, $layout, $nodeShape);
        $outputImage = $this->imageGenerator->render($format, $dotFile);

        return new BinaryFileResponse(
            $outputImage,
            BinaryFileResponse::HTTP_OK,
            ['Content-Type' => $this->imageGenerator->getMimeType($format)]
        );
    }
}
