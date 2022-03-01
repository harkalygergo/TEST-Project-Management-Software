<?php

namespace App\Controller;

use PDO;
use PDOException;

class DatabaseConnection
{
    public function __construct(
        private ?string $user = null,
        private ?string $password = null,
        private ?object $connection = null
    )
    {
        $configFile = __DIR__.'/../../config/config.ini';
        $config = parse_ini_file($configFile, true);

        $this->user = $config['database']['db_user'];
        $this->password = $config['database']['db_password'];

        $this->connection = $this->getConnection();
    }

    public function getConnection()
    {
        if(!is_object($this->connection))
        {
            return $this->connect();
        }

        return $this->connection;
    }

    private function connect()
    {
        try {
            return new PDO('mysql:host=localhost;dbname=localhost_test_weloveshirts', $this->user, $this->password);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
