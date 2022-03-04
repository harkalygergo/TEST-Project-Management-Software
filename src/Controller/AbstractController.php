<?php

namespace App\Controller;

abstract class AbstractController
{
    public function __construct(
        private ?array $config = null
    )
    {
        $configFile = __DIR__.'/../../config/config.ini';
        if(file_exists($configFile))
        {
            $this->config = $this->setConfig($configFile);
            ($this->config['application']['debug']) ? $this->show_errors() : $this->hide_errors(); // debug
        }
        else
        {
            die('First create config/config.ini file!');
        }
    }

    public function getConfig(): ?array
    {
        return $this->config;
    }

    private function setConfig($configFile)
    {
        if(is_null($this->config))
        {
            return parse_ini_file($configFile, true);
        }
        else
        {
            return $this->config;
        }
    }

    private function show_errors()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    private function hide_errors()
    {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}
