<?php

namespace Figurare\Abstracts\Ladle\Exceptions;

use Throwable;

/**
 * Interface TemplateNotFoundExceptionInterface
 *
 * @package Figurare\Abstracts\Ladle\Exceptions
 */
interface TemplateNotFoundExceptionInterface extends Throwable
{
    /**
     * TemplateNotFoundException constructor.
     *
     * @param string $templatePath Target template path
     * @param array $templateDirectoryList Template resolving directories
     * @param int $code Error code
     * @param Throwable|null $previous Previous throwable object
     */
    public function __construct(string $templatePath, array $templateDirectoryList, int $code = 0, Throwable $previous = null);

}