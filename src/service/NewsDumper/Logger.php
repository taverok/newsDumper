<?php

namespace repofor\NewsDumper;


class Logger
{
    private $path;
    private $isActive;
    private $logToConsole;
    private $defaultPath = '/var/logs/';
    private $logFile = "app.log";

    public function __construct($config)
    {
        $this->path = $config['rootDir']
            . (array_key_exists("logPath", $config) ? $config["logPath"] : $this->defaultPath);
        $this->isActive = array_key_exists("logActive", $config) ? $config["logActive"] : false;
        $this->logToConsole = array_key_exists("logToConsole", $config) ? $config["logToConsole"] : false;
    }

    public function log($text, $category = 'info')
    {
        if (!$this->isActive){
            return;
        }

        $text = is_string($text) ? $text : json_encode($text);
        $text = date('Y-m-d H:i:s'). " [ $category ] $text \n";

        if ($this->logToConsole){
            print_r($text);
        }

        if (!is_dir($this->path)){
            mkdir($this->path, 0777, true);
        }

        file_put_contents($this->path . $this->logFile, $text, FILE_APPEND);
    }
}