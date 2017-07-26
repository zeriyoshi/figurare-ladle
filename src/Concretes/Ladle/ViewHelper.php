<?php

namespace Figurare\Concretes\Ladle;

use Figurare\Abstracts\Ladle\ViewHelperInterface;
use Figurare\Abstracts\Ladle\ViewInterface;
use Figurare\Abstracts\Ladle\ViewManagerInterface;

/**
 * Class ViewHelper
 *
 * @package Figurare\Concretes\Ladle
 */
class ViewHelper implements ViewHelperInterface
{
    public $variables;
    protected $view;
    protected $manager;
    protected $sections;

    /**
     * ViewHelperInterface constructor.
     *
     * @param ViewManagerInterface $manager ViewManager instance
     */
    public function __construct(ViewManagerInterface $manager)
    {
        $this->variables    = null;
        $this->view         = null;
        $this->manager      = $manager;
        $this->sections     = [];
    }

    /**
     * Set a View instance.
     *
     * @param ViewInterface $view View instance
     * @return ViewHelperInterface
     */
    public function setView(ViewInterface $view): ViewHelperInterface
    {
        $this->view         = $view;
        $this->variables    = (object) $view->getVariables();

        return $this;
    }

    /**
     * Join another template.
     *
     * @param string $templatePath Template absolute path
     */
    public function join_template(string $templatePath): void
    {
        $this->manager->execute(
            $this->manager->compile($templatePath),
            $this
        );
    }

    /**
     * Start a section.
     *
     * @param string $sectionName Section name
     */
    public function ladle_start_section(string $sectionName): void
    {
        ob_start(function ($buffer) use ($sectionName) {
            $this->sections[$sectionName] = $buffer;
        });
    }

    /**
     * End a section.
     */
    public function ladle_end_section(): void
    {
        ob_end_clean();
    }

    /**
     * Yielding section.
     *
     * @param string $sectionName Section name
     */
    public function ladle_yield(string $sectionName): void
    {
        $this->ladle_unsafe_print(isset($this->sections[$sectionName]) ? $this->sections[$sectionName] : null);
    }

    /**
     * Print variable with escape.
     *
     * @param string $variable Variable name
     */
    public function ladle_safe_print(string $variable): void
    {
        $this->ladle_unsafe_print(htmlspecialchars($variable));
    }

    /**
     * Print variable without escape.
     *
     * @param string $variable Variable name
     */
    public function ladle_unsafe_print(string $variable): void
    {
        echo $variable;
    }
}