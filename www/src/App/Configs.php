<?php

$container->set('db_settings', function(){
    $settings = [
       'DB_NAME' => 'tenis',
       'DB_USER' => 'docker',
       'DB_PASS' => 'test',
       'DB_HOST' => 'database',
       'DB_CHARSET' => 'utf8',
    ];

    return (object) $settings;
});