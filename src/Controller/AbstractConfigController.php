<?php

namespace App\Controller;

class AbstractConfigController
{
    public function __construct(
        private ?array $config = null
    )
    {
        $configFile = __DIR__.'/../../config/config.ini';
        $this->config = parse_ini_file($configFile, true);
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
