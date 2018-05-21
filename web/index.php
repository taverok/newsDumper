<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $rootDir = dirname(__DIR__);
    $config = require_once $rootDir.'/config/main.php';
    $config = array_merge($config, ['rootDir' => $rootDir]);

    require_once $rootDir . '/vendor/autoload.php';

    $request = 'button';

    if (array_key_exists('QUERY_STRING', $_SERVER)){
        parse_str($_SERVER['QUERY_STRING'], $query);

        if (array_key_exists('r', $query)){
            $request = $query['r'];
            $request = str_replace(['.', '/', '\\'], '',$request);
        }
    }

    require "$rootDir/src/controller/$request.php";
