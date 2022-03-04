<?php

namespace App\Controller;

use PDO;
use PDOException;

class DatabaseController extends AbstractController
{
    public function __construct(
        private ?string $user = null,
        private ?string $password = null,
        private ?string $dbname = null,
        private ?object $connection = null
    )
    {
        parent::__construct();

        $this->user = $this->getConfig()['database']['db_user'];
        $this->password = $this->getConfig()['database']['db_password'];
        $this->dbname = $this->getConfig()['database']['db_name'];

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
            return new PDO('mysql:host=localhost;dbname='.$this->dbname, $this->user, $this->password);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
