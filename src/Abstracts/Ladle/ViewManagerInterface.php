<?php

namespace Figurare\Abstracts\Ladle;

use Figurare\Concretes\Ladle\Exceptions\TemplateNotFoundException;

/**
 * Interface ViewManagerInterface
 *
 * @package Figurare\Abstracts\Ladle
 */
interface ViewManagerInterface
{
    /**
     * ViewManagerInterface constructor.
     *
     * @param ViewCompilerInterface $compiler ViewCompiler instance
     */
    public function __construct(ViewCompilerInterface $compiler);

    /**
     * Set a ViewCompiler instance.
     *
     * @param ViewCompilerInterface $compiler ViewCompiler instance
     * @return ViewManagerInterface ViewManager instance
     */
    public function setViewCompiler(ViewCompilerInterface $compiler) : ViewManagerInterface;

    /**
     * Get a ViewCompiler instance.
     *
     * @return ViewCompilerInterface ViewCompiler instance
     */
    public function getViewCompiler() : ViewCompilerInterface;

    /**
     * Add template resolving directory path.
     *
     * @param string $templatePath Template resolving directory path
     * @param bool $prepend If true, prepend the resolving path on the resolving path stack instead of appending it.
     * @return ViewManagerInterface ViewManager instance
     */
    public function addTemplatePath(string $templatePath, bool $prepend = false) : ViewManagerInterface;

    /**
     * Remove template resolving directory path.
     *
     * @param string $templatePath Template resolving directory path
     * @return ViewManagerInterface ViewManager instance
     */
    public function removeTemplatePath(string $templatePath) : ViewManagerInterface;

    /**
     * Set a compiled template save directory path.
     *
     * @param string $compiledTemplateSavePath Compiled template save directory path
     * @return ViewManagerInterface ViewManager instance
     */
    public function setCompiledTemplateSavePath(string $compiledTemplateSavePath) : ViewManagerInterface;

    /**
     * Get a compiled template save directory path.
     *
     * @return null|string Compiled template save directory path
     */
    public function getCompiledTemplateSavePath() : ?string;

    /**
     * Rendering view.
     *
     * @param ViewInterface $view View instance
     * @param ViewHelperInterface $helper ViewHelper instance
     */
    public function rendering(ViewInterface $view, ViewHelperInterface $helper) : void;

    /**
     * Execute template.
     *
     * @param string $compiledTemplatePath Compiled view relative path
     * @param ViewHelperInterface $helper ViewHelper instance
     */
    public function execute(string $compiledTemplatePath, ViewHelperInterface $helper) : void;

    /**
     * Compile ladle template to native PHP script.
     *
     * @param string $templatePath Template relative path
     * @return null|string Native PHP script code
     * @throws TemplateNotFoundException
     */
    public function compile(string $templatePath) : ?string;
}