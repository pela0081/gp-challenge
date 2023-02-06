<?php

use Slim\Routing\RouteCollectorProxy;
use App\Middlewares\JsonBodyParserMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
    return $response;
});

$app->group('/api', function(RouteCollectorProxy $group) {
    $group->get('/players/all', 'App\Controllers\PlayersController:all');
    $group->post('/players/create', 'App\Controllers\PlayersController:create');
    $group->get('/players/view/{id:[0-9]+}', 'App\Controllers\PlayersController:view');

    $group->get('/torneos/all', 'App\Controllers\TorneosController:all');
    $group->post('/torneos/create', 'App\Controllers\TorneosController:create');
    $group->get('/torneos/view/{id:[0-9]+}', 'App\Controllers\TorneosController:view');
})->add(new JsonBodyParserMiddleware());

$app->any('/{path:.*}', 'App\Controllers\DefaultController:notFound');