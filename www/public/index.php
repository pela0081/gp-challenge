<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

header('Access-Control-Allow-Origin:*'); 
header('Access-Control-Allow-Headers:X-Request-With');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

AppFactory::setContainer(new \DI\Container());
$app = AppFactory::create();
$container = $app->getContainer();

require __DIR__ . '/../src/App/Configs.php';
require __DIR__ . '/../src/App/Dependencies.php';
require __DIR__ . '/../src/App/Routes.php';

$app->run();