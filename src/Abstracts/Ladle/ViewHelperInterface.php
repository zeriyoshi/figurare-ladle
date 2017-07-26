<?php

namespace Figurare\Abstracts\Ladle;

/**
 * Interface ViewHelperInterface
 *
 * @package Figurare\Abstracts\Ladle
 */
interface ViewHelperInterface
{
    /**
     * ViewHelperInterface constructor.
     *
     * @param ViewManagerInterface $manager ViewManager instance
     */
    public function __construct(ViewManagerInterface $manager);

    /**
     * Set a View instance.
     *
     * @param ViewInterface $view View instance
     * @return ViewHelperInterface
     */
    public function setView(ViewInterface $view) : ViewHelperInterface;

    /**
     * Join another template.
     *
     * @param string $templatePath Template absolute path
     */
    public function join_template(string $templatePath) : void;

    /**
     * Start a section.
     *
     * @param string $sectionName Section name
     */
    public function ladle_start_section(string $sectionName) : void;

    /**
     * End a section.
     */
    public function ladle_end_section() : void;

    /**
     * Yielding section.
     *
     * @param string $sectionName Section name
     */
    public function ladle_yield(string $sectionName) : void;

    /**
     * Print variable with escape.
     *
     * @param string $variable Variable name
     */
    public function ladle_safe_print(string $variable) : void;

    /**
     * Print variable without escape.
     *
     * @param string $variable Variable name
     */
    public function ladle_unsafe_print(string $variable) : void;
}