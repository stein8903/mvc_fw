<?php

namespace Core;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = '../App/Views/' . $view;

        if (is_readable($file)) {
            require $file;
        } else {
            echo $file . ' not found..';
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader('../App/Views');
        $twig = new \Twig\Environment($loader);
        
        $domainUrl = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
        $twig->addGlobal('domainUrl', $domainUrl);
        $publicUrl = $domainUrl . dirname($_SERVER['SCRIPT_NAME']);
        $twig->addGlobal('publicUrl', $publicUrl);
        
        echo $twig->render($template, $args);
    }
}
