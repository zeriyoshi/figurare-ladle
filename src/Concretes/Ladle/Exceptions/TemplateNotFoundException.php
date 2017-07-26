<?php

namespace Figurare\Concretes\Ladle\Exceptions;

use Figurare\Abstracts\Ladle\Exceptions\TemplateNotFoundExceptionInterface;
use RuntimeException;
use Throwable;

/**
 * Class TemplateNotFoundException
 *
 * @package Figurare\Concretes\Ladle\Exceptions
 */
class TemplateNotFoundException extends RuntimeException implements TemplateNotFoundExceptionInterface
{
    /**
     * TemplateNotFoundException constructor.
     *
     * @param string $templatePath Target template path
     * @param array $templateDirectoryList Template resolving directories
     * @param int $code Error code
     * @param Throwable|null $previous Previous throwable object
     */
    public function __construct(string $templatePath, array $templateDirectoryList, int $code = 0, Throwable $previous = null)
    {
        $message = ('Could not found template "'.$templatePath.'" in '.implode(', ', $templateDirectoryList).'.');

        parent::__construct($message, $code, $previous);
    }
}