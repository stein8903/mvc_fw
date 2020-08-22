<?php
require '../vendor/autoload.php';

$route = new Core\Router();

$route->add('', ['controller' => 'Home', 'action' => 'index']);
$route->add('{controller}/{action}');
$route->add('{controller}/{id:\d+}/{action}');

$route->dispatch($_SERVER['QUERY_STRING']);