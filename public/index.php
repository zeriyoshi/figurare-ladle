<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$compiler = new \Figurare\Concretes\Ladle\ViewCompiler();

$manager = (new \Figurare\Concretes\Ladle\ViewManager($compiler))
    ->addTemplatePath(__DIR__.'/../test/resources/views')
    ->addTemplatePath(__DIR__.'/../test/resources/views/layout')
    ->setCompiledTemplateSavePath(__DIR__.'/../test/resources/compiled_views');

$view = (new \Figurare\Concretes\Ladle\View())
    ->setTemplatePath('index.ladle.html')
    ->addVariable('title', 'figurare ladle')
    ->addVariable('github_uri', 'https://github.com/zeriyoshi/figurare-ladle')
    ->addVariable('header', '<span class="indigo-text">figurare ladle</span> - Yet another PHP Template Engine.')
    ->addVariable('description', 'figurare-ladle is a Simple and Flexible Template Engine, Inspired from Laravel Blade.')
    ->addVariable('current_hour', (int)(new DateTime())->format('G'));

$helper = new \Figurare\Concretes\Ladle\ViewHelper($manager);

$manager->rendering($view, $helper);