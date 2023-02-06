<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DefaultController extends BaseController {
    
    public function index(Request $request, Response $response, $args)
    {
        $pdo = $this->container->get('db');
        $query = $pdo->query("SELECT * FROM Personaaa");
        $result = $query->fetchAll();
        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function notFound(Request $request, Response $response, $args)
    {
        $response->getBody()->write('No se encuentra');
        return $response
            ->withStatus(404, 'No se encuentra');
    }
}