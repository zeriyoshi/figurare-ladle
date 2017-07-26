<?php

namespace Figurare\Concretes\Ladle;

use Figurare\Abstracts\Ladle\ViewCompilerInterface;

/**
 * Class ViewCompiler
 *
 * @package Figurare\Concretes\Ladle
 */
class ViewCompiler implements ViewCompilerInterface
{
    protected $extends;

    /**
     * Compile ladle template to native PHP script.
     *
     * @param string $templateString Ladle template string
     * @return null|string native PHP script
     */
    public function compile(string $templateString): ?string
    {
        $this->extends = [];

        $templateString = $this->compilePrintTags(
            $this->compileAsteriskTags(
                $this->compilePercentTags($templateString)
            )
        );

        foreach ($this->extends as $extend) {
            $templateString .= (PHP_EOL.$extend);
        }

        return trim($templateString);
    }

    /**
     * Compile print tags.
     *
     * @param string $templateString Ladle template string
     * @return string Compiled string
     */
    protected function compilePrintTags(string $templateString) : string
    {
        return preg_replace_callback('/\{\{(.*?)\}\}/', function ($matches) {
            $isUnEscape = false;

            // Check and replace un-escape syntax.
            $inner = preg_replace_callback('/^\!(.*?)\!$/', function ($unEscapeMatches) use (&$isUnEscape) {
                $isUnEscape = true;
                return trim($unEscapeMatches[1]);
            }, trim($matches[1]));

            // Replace get variables from helper.
            $inner = preg_replace_callback('/\$(.*?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/', function ($variableMatches) {
                return ('$_figurare_ladle_helper->variables->'.trim($variableMatches[1]));
            }, $inner);

            // Replace OR syntax.
            $inner = preg_replace_callback('/(.*?)\|\s(.*?)$/', function ($substituteMatches) {
                return ('isset('.trim($substituteMatches[1]).') ? '.trim($substituteMatches[1]).' : '.trim($substituteMatches[2]));
            }, $inner);

            if ($isUnEscape) {
                $inner = ('$_figurare_ladle_helper->ladle_unsafe_print('.$inner.');');
            } else {
                $inner = ('$_figurare_ladle_helper->ladle_safe_print('.$inner.');');
            }

            return ('<?php '.$inner.' ?>');
        }, $templateString);
    }

    /**
     * Compile asterisk (Control flow) tags.
     *
     * @param string $templateString Ladle template string
     * @return string Compiled string
     */
    protected function compileAsteriskTags(string $templateString) : string
    {
        return preg_replace_callback('/\{\*(.*?)\*\}/', function ($matches) {;
            // Replace get variables from helper.
            $matches[1] = preg_replace_callback('/\$(.*?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/', function ($innerMatches) {
                return ('$_figurare_ladle_helper->variables->'.trim($innerMatches[1]));
            }, trim($matches[1]));

            return ('<?php '.trim($matches[1]).'; ?>');
        }, $templateString);
    }

    /**
     * Compile percent (Helper methods) tags.
     * 
     * @param string $templateString Ladle template string
     * @return string Compiled string
     */
    protected function compilePercentTags(string $templateString) : string
    {
        return preg_replace_callback('/\{\%(.*?)\%\}/', function ($matches) {
            // Replace extends method.
            if (preg_match('/extends\s*\((.*?)\)/', trim($matches[1]), $extends_matches) === 1) {
                $this->extends[] = ('<?php $_figurare_ladle_helper->join_template('.$extends_matches[1].'); ?>');
                return '';
            }

            return ('<?php $_figurare_ladle_helper->ladle_'.trim($matches[1]).'; ?>');
        }, $templateString);
    }
}