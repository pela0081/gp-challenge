<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class PlayersController extends BaseController {
    
    /**
     * @OA\Get(
     *     tags={"Jugadores"},
     *     path="/api/players/all",
     *     description="Obtiene una lista de los jugadores",
     *     @OA\Response(
     *      response="200",
     *      description="Lista de jugadores",
     *     )
     * )
     */
    public function all(Request $request, Response $response, $args)
    {
        $model = $this->getModel('Player');
        $result = $model->getAll();
        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @OA\Get(
     *     tags={"Jugadores"},
     *     path="/api/players/view/{id}",
     *     description="Obtiene el detalle de un jugador",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del jugador",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Detalle del jugador",
     *     )
     * )
     */
    public function view(Request $request, Response $response, $args)
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        
        $id = $route->getArgument('id');

        $model = $this->getModel('Player');
        $result = $model->getOne($id);
        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @OA\Post(
     *     tags={"Jugadores"},
     *     path="/api/players/create",
     *     description="Crea nuevo jugador",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Nombre"),
     *              @OA\Property(property="tipo", type="integer", enum={0, 1}, description="0 = Masculino, 1 = Femenino"),
     *              @OA\Property(property="habilidad", type="integer", example=80),
     *              @OA\Property(property="fuerza", type="integer", example=80),
     *              @OA\Property(property="velocidad", type="integer", example=80),
     *              @OA\Property(property="reaccion", type="integer", example=80),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Jugador creado",
     *     )
     * )
     */
    public function create(Request $request, Response $response, $args)
    {
        $payload = $request->getParsedBody();
        $model = $this->getModel('Player');
        $result = $model->insert($payload);
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}