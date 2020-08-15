<?php

spl_autoload_register(function ($class){
    $root = dirname(__DIR__);
    $file = str_replace('\\', '/', $class);
    require $root . '/' . $file . '.php';
});

$route = new Core\Router();

$route->add('', ['controller' => 'Home', 'action' => 'index']);
$route->add('{controller}/{action}');
$route->add('{controller}/{id:\d+}/{action}');

var_dump($route->getRouters());

$route->dispatch($_SERVER['QUERY_STRING']);