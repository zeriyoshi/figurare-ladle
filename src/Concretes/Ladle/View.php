<?php

namespace Figurare\Concretes\Ladle;

use Figurare\Abstracts\Ladle\ViewInterface;

/**
 * Class View
 *
 * @package Figurare\Concretes\Ladle
 */
class View implements ViewInterface
{
    protected $templatePath;
    protected $variables;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->templatePath = null;
        $this->variables = [];
    }

    /**
     * Set a template path.
     *
     * @param string $templatePath Template path
     * @return ViewInterface View instance
     */
    public function setTemplatePath(string $templatePath): ViewInterface
    {
        $this->templatePath = $templatePath;
        return $this;
    }

    /**
     * Get a template path.
     *
     * @return null|string Template path
     */
    public function getTemplatePath(): ?string
    {
        return $this->templatePath;
    }

    /**
     * Set a template variable.
     *
     * @param string $name Variable name
     * @param mixed $value Variable value
     * @return ViewInterface View instance
     */
    public function addVariable(string $name, $value): ViewInterface
    {
        $this->variables[$name] = $value;
        return $this;
    }

    /**
     * Set a template variables.
     *
     * @param array $variables Variables array
     * @return ViewInterface View instance
     */
    public function addVariables(array $variables): ViewInterface
    {
        $this->variables = array_merge($this->variables, $variables);
        return $this;
    }

    /**
     * Get a template variable value.
     *
     * @param string $name Variable name
     * @return mixed Variable data
     */
    public function getVariable(string $name)
    {
        return isset($this->variables[$name]) ? $this->variables[$name] : null;
    }

    /**
     * Get a template variables array.
     *
     * @return array Variables array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Remove a template variable.
     *
     * @param string $name Variable name.
     * @return ViewInterface View instance
     */
    public function removeVariable(string $name): ViewInterface
    {
        if (isset($this->variables[$name])) {
            unset($this->variables[$name]);
        }

        return $this;
    }

    /**
     * Flush all template variables.
     *
     * @return ViewInterface View instance
     */
    public function flushVariables(): ViewInterface
    {
        $this->variables = [];
        return $this;
    }
}