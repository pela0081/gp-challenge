<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

/**
 * @OA\Server(url="http://localhost:8080/")
 * @OA\Info(title="Torneo de tenis", version="0.1", description="Geopagos challenge")
 */
class BaseController {

    protected $container;

    public function __construct(ContainerInterface $c)
    {
        $this->container = $c;
    }

    public function getModel($model_name = null)
    {
        $model_name = "\\App\\Models\\$model_name";
        $model = new $model_name($this->container->get('pdo'));

        return $model;
    }
}