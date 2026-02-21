<?php

namespace MadMind\StateMachineVisualizationBundle\Service;

use MadMind\StateMachineVisualizationBundle\Exception\RendererException;

interface ImageGeneratorInterface
{
    /**
     * @return string Path to the created image file
     *
     * @throws RendererException
     */
    public function render(string $format, string $dotFilePath): string;

    public function supports(string $format): bool;

    public function getMimeType(string $format): string;
}
