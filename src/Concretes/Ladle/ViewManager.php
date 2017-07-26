<?php

namespace Figurare\Concretes\Ladle;

use Figurare\Abstracts\Ladle\ViewCompilerInterface;
use Figurare\Abstracts\Ladle\ViewHelperInterface;
use Figurare\Abstracts\Ladle\ViewInterface;
use Figurare\Abstracts\Ladle\ViewManagerInterface;
use Figurare\Concretes\Ladle\Exceptions\TemplateNotFoundException;

/**
 * Class ViewManager
 *
 * @package Figurare\Concretes\Ladle
 */
class ViewManager implements ViewManagerInterface
{
    protected $compiler;
    protected $templateDirectoryList;
    protected $compiledTemplateSavePath;

    /**
     * ViewManagerInterface constructor.
     *
     * @param ViewCompilerInterface $compiler ViewCompiler instance
     */
    public function __construct(ViewCompilerInterface $compiler)
    {
        $this->compiler = $compiler;
        $this->templateDirectoryList = [];
        $this->compiledTemplateSavePath = null;
    }

    /**
     * Set a ViewCompiler instance.
     *
     * @param ViewCompilerInterface $compiler ViewCompiler instance
     * @return ViewManagerInterface ViewManager instance
     */
    public function setViewCompiler(ViewCompilerInterface $compiler): ViewManagerInterface
    {
        $this->compiler = $compiler;
        return $this;
    }

    /**
     * Get a ViewCompiler instance.
     *
     * @return ViewCompilerInterface ViewCompiler instance
     */
    public function getViewCompiler(): ViewCompilerInterface
    {
        return $this->compiler;
    }

    /**
     * Add template resolving directory path.
     *
     * @param string $templatePath Template resolving directory path
     * @param bool $prepend If true, prepend the resolving path on the resolving path stack instead of appending it.
     * @return ViewManagerInterface ViewManager instance
     */
    public function addTemplatePath(string $templatePath, bool $prepend = false): ViewManagerInterface
    {
        $templatePath = $this->normalizePath($templatePath);

        if (in_array($templatePath, $this->templateDirectoryList)) {
            $this->removeTemplatePath($templatePath);
        }

        if ($prepend) {
            array_unshift($this->templateDirectoryList, $templatePath);
        } else {
            array_push($this->templateDirectoryList, $templatePath);
        }

        return $this;
    }

    /**
     * Remove template resolving directory path.
     *
     * @param string $templatePath Template resolving directory path
     * @return ViewManagerInterface ViewManager instance
     */
    public function removeTemplatePath(string $templatePath): ViewManagerInterface
    {
        foreach ($this->templateDirectoryList as $key => $value) {
            if ($value === $templatePath) {
                unset($this->templateDirectoryList[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Set a compiled template save directory path.
     *
     * @param string $compiledTemplateSavePath Compiled template save directory path
     * @return ViewManagerInterface ViewManager instance
     */
    public function setCompiledTemplateSavePath(string $compiledTemplateSavePath): ViewManagerInterface
    {
        $this->compiledTemplateSavePath = $this->normalizePath($compiledTemplateSavePath);
        return $this;
    }

    /**
     * Get a compiled template save directory path.
     *
     * @return null|string Compiled template save directory path
     */
    public function getCompiledTemplateSavePath(): ?string
    {
        return $this->compiledTemplateSavePath;
    }

    /**
     * Rendering view.
     *
     * @param ViewInterface $view View instance
     * @param ViewHelperInterface $helper ViewHelper instance
     */
    public function rendering(ViewInterface $view, ViewHelperInterface $helper): void
    {
        $helper->setView($view);
        $compiledViewFilePath = $this->compile($view->getTemplatePath());
        $this->execute($compiledViewFilePath, $helper);
    }

    /**
     * Execute template.
     *
     * @param string $compiledTemplatePath Compiled view relative path
     * @param ViewHelperInterface $helper ViewHelper instance
     */
    public function execute(string $compiledTemplatePath, ViewHelperInterface $helper): void
    {
        $_figurare_ladle_helper = $helper;
        $helperSandbox = function ($compiledTemplatePath) use ($_figurare_ladle_helper) {
            include($compiledTemplatePath);
        };

        $helperSandbox($compiledTemplatePath);
    }

    /**
     * Compile ladle template to native PHP script.
     *
     * @param string $templatePath Template relative path
     * @return null|string Native PHP script code
     */
    public function compile(string $templatePath): ?string
    {
        $templateString = file_get_contents($this->resolveAbsolutePath($templatePath));

        if (!file_exists($this->compiledTemplateSavePath)) {
            mkdir($this->compiledTemplateSavePath);
        }

        $compiledTemplateFilePath = ($this->compiledTemplateSavePath.md5($templateString));

        if (file_exists($compiledTemplateFilePath)) {
            return $compiledTemplateFilePath;
        }

        $compiledTemplateString = $this->compiler->compile($templateString);

        file_put_contents($compiledTemplateFilePath, $compiledTemplateString);

        return $compiledTemplateFilePath;
    }

    /**
     * Normalize path.
     *
     * @param string $path Path
     * @return string Normalized path
     */
    protected function normalizePath(string $path) : string
    {
        return ('/' . rtrim(ltrim($path, '/'), '/') . '/');
    }

    /**
     * Resolve template absolute path.
     *
     * @param string $templatePath Template relative path
     * @return string Template absolute path
     * @throws TemplateNotFoundException
     */
    protected function resolveAbsolutePath(string $templatePath) : string
    {
        foreach ($this->templateDirectoryList as $templateDirectory) {
            $templateRealPath = ($templateDirectory.$templatePath);

            if (file_exists($templateRealPath)) {
                return $templateRealPath;
            }
        }

        throw new TemplateNotFoundException($templatePath, $this->templateDirectoryList);
    }
}