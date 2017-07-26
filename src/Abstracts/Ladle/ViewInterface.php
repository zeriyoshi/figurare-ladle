<?php

namespace Figurare\Abstracts\Ladle;

/**
 * Interface ViewInterface
 *
 * @package Figurare\Abstracts\Ladle
 */
interface ViewInterface
{
    /**
     * Set a template path.
     *
     * @param string $templatePath Template path
     * @return ViewInterface View instance
     */
    public function setTemplatePath(string $templatePath) : ViewInterface;

    /**
     * Get a template path.
     *
     * @return null|string Template path
     */
    public function getTemplatePath() : ?string;

    /**
     * Set a template variable.
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     * @return ViewInterface View instance
     */
    public function addVariable(string $name, $value) : ViewInterface;

    /**
     * Set a template variables.
     *
     * @param array $variables Variables array
     * @return ViewInterface View instance
     */
    public function addVariables(array $variables) : ViewInterface;

    /**
     * Get a template variable value.
     *
     * @param string $name Variable name
     * @return mixed Variable data
     */
    public function getVariable(string $name);

    /**
     * Get a template variables array.
     *
     * @return array Variables array
     */
    public function getVariables() : array;

    /**
     * Remove a template variable.
     *
     * @param string $name Variable name.
     * @return ViewInterface View instance
     */
    public function removeVariable(string $name) : ViewInterface;

    /**
     * Flush all template variables.
     *
     * @return ViewInterface View instance
     */
    public function flushVariables() : ViewInterface;
}