<?php

namespace App\Controller;

class AbstractConfigController
{
    public function __construct(
        private ?array $config = null
    )
    {
        $configFile = __DIR__.'/../../config/config.ini';
        if(file_exists($configFile))
        {
            $this->config = parse_ini_file($configFile, true);
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

    public function setConfig(?array $config): void
    {
        $this->config = $config;
    }
}
