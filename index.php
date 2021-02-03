<?php

error_reporting(E_ALL);
ini_set('display_errors',true);

require $_SERVER['DOCUMENT_ROOT'] . '/helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

use App\Router;
use App\Application;
use App\Controller\MainController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Session;

$router = new Router(new Session());
$router->session->start();

$router->get('/', MainController::class . '@index', 0);
$router->get('/about/*/12/*/', MainController::class . '@about', 0);
$router->get('/signin', MainController::class . '@signin', 0);
$router->get('/signup', MainController::class . '@signup', 0);
$router->get('/login', AuthController::class . '@login', 0, 'POST');
$router->get('/logout', AuthController::class . '@logout', 0);
$router->get('/admin/users', AdminController::class . '@users', 6);


$application = new Application($router);

$application->run();
echo '<pre>';
var_dump($_GET);
echo '</pre>';
