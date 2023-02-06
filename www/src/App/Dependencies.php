<?php

use Psr\Container\ContainerInterface;

$container->set('pdo', function(ContainerInterface $c){
    $settings = $c->get('db_settings');
    
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES, false,
    ];

    $dsn = "mysql:host=$settings->DB_HOST;dbname=$settings->DB_NAME;charset=$settings->DB_CHARSET";
    
    return new PDO($dsn, $settings->DB_USER, $settings->DB_PASS, $options);
});