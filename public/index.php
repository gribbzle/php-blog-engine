<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\ArticleController;
use App\Router;

$router = new Router();

$router->get('/', function () {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/category/{id}', function (string $id) {
    $controller = new CategoryController();
    $controller->show($id);
});

$router->get('/article/{id}', function (string $id) {
    $controller = new ArticleController();
    $controller->show($id);
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);