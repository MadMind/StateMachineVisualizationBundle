<?php

namespace MadMind\StateMachineVisualizationBundle\Service;

use MadMind\StateMachineVisualizationBundle\Exception\RendererException;

class DotImageGenerator implements ImageGeneratorInterface
{
    protected $dotExecutable;
    protected $cacheDir;
    protected $supportedMimeTypes = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
    ];

    public function __construct($dotExecutable, $cacheDir)
    {
        $this->dotExecutable = $dotExecutable;
        $this->cacheDir = $cacheDir;
    }

    public function render($format, $dotFilePath)
    {
        if (!is_executable($this->dotExecutable)) {
            throw new RendererException($this->dotExecutable.' is not executable');
        }

        $outputImage = sprintf('%s/smv_%s.%s', $this->cacheDir, md5($dotFilePath), $format);
        if (file_exists($outputImage)) {
            return $outputImage;
        }

        $cmd = sprintf(
            "%s -T%s -o %s %s",
            escapeshellarg($this->dotExecutable),
            $format,
            escapeshellarg($outputImage),
            escapeshellarg($dotFilePath)
        );

        exec($cmd, $execOutput, $execCode);
        if ($execCode != 0) {
            throw new RendererException('Image not generated');
        }

        return $outputImage;
    }

    public function supports($format)
    {
        return !empty($this->supportedMimeTypes[$format]);
    }

    public function getMimeType($format)
    {
        if (!empty($this->supportedMimeTypes[$format])) {
            return $this->supportedMimeTypes[$format];
        }

        return '';
    }
}
