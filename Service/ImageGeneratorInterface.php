<?php

namespace MadMind\StateMachineVisualizationBundle\Service;

use MadMind\StateMachineVisualizationBundle\Exception\RendererException;

interface ImageGeneratorInterface
{
    /**
     * @param string $format
     * @param string $dotFilePath
     *
     * @return string Path to created image file
     *
     * @throws RendererException
     */
    public function render($format, $dotFilePath);

    /**
     * @param string $format
     *
     * @return bool
     */
    public function supports($format);

    /**
     * @param string $format
     *
     * @return string
     */
    public function getMimeType($format);
}
