<?php

declare(strict_types=1);

namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function render(string $view, array $args = []): void
    {
        extract($args, EXTR_SKIP);
        $file = "../App/Views/$view";

        if (is_readable($file)){
            require $file;
        } else {
            throw new \Exception("File $file not found");
        }
    }

    public static function renderTemplate(string $template, array $args = []): void
    {
        static $twig = null;

        if ($twig === null){
            $loader = new FilesystemLoader('../App/Views');
            $twig = new Environment($loader);
        }

        if (!is_string($twig->render($template))){
            throw new \Exception("File $template not found");
        } else {
            echo $twig->render($template, $args);
        }
    }
}