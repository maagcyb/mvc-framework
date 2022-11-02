<?php
use Core\Router;

//echo phpinfo();

/**
 * Autoloader
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Router();
$router->add('/admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('/', ['controller' => 'home', 'action' => 'index']);
$router->add('/{controller}');
$router->add('/{controller}/{action}');
$router->add('/{controller}/{id:\d+}/{action}');

$url = $_SERVER['REQUEST_URI'];
$router->dispatch($url);

