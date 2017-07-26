<?php

namespace Figurare\Abstracts\Ladle;

/**
 * Interface ViewCompilerInterface
 *
 * @package Figurare\Abstracts\Ladle
 */
interface ViewCompilerInterface
{
    /**
     * Compile ladle template to native PHP script.
     *
     * @param string $templateString Ladle template string
     * @return null|string native PHP script
     */
    public function compile(string $templateString) : ?string;
}