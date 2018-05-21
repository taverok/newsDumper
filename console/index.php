<?php

$rootDir = dirname(__DIR__);
$config = require_once $rootDir.'/config/main.php';
$config = array_merge($config, ['rootDir' => $rootDir]);

require_once $rootDir . '/vendor/autoload.php';

$command = array_key_exists(1, $argv) ? $argv[1] : null;

if (!$command){
    die("No command provided".PHP_EOL);
}

$command = str_replace(['.', '\\'], '',$command);

require "$rootDir/console/controller/$command.php";
