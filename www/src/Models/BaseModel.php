<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

class BaseModel {

    protected $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    protected function getModel($model_name = null)
    {
        $model_name = "\\App\\Models\\$model_name";
        $model = new $model_name($this->db);

        return $model;
    }
}