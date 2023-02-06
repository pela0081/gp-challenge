<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class TorneosController extends BaseController {
    
    /**
     * @OA\Get(
     *     tags={"Torneos"},
     *     path="/api/torneos/all",
     *     description="Obtinene una lista de los torneos",
     *     @OA\Response(
     *      response="200",
     *      description="Lista de los torneos",
     *     )
     * )
     */
    public function all(Request $request, Response $response, $args)
    {
        $model = $this->getModel('Torneo');
        $result = $model->getAll();
        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @OA\Get(
     *     tags={"Torneos"},
     *     path="/api/torneos/view/{id}",
     *     description="Obtiene el detalle de un torneo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del torneo",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Detalle del torneo",
     *     )
     * )
     */
    public function view(Request $request, Response $response, $args)
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        
        $id = $route->getArgument('id');

        $model = $this->getModel('Torneo');
        $result = $model->getOne($id);
        $response->getBody()->write(json_encode($result));
        
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @OA\Post(
     *     tags={"Torneos"},
     *     path="/api/torneos/create",
     *     description="Crea nuevo torneo y obtiene un ganador",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Grand Slam"),
     *              @OA\Property(property="tipo", enum={"0", "1"}, description="0 = Masculino, 1 = Femenino"),
     *              @OA\Property(property="jugadores", type="array", example="[1,2,3,4,5,6,7,8]", @OA\Items(type="integer")),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ID del ganador",
     *     )
     * )
     */
    public function create(Request $request, Response $response, $args)
    {
        $payload = $request->getParsedBody();
        $model = $this->getModel('Torneo');
        $torneo = $model->insertTorneo($payload);

        $result = $model->comenzarTorneo($torneo->id, $payload['jugadores']);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}