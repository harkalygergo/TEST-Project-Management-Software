<?php

namespace App\Manager;

use App\Controller\DatabaseController;

class DatabaseManager implements DatabaseManagerInterface
{
    public function __construct(
        private ?DatabaseController $databaseConnection = new DatabaseController()
    ) {}

    public function query(string $query)
    {
        $pdo = $this->connection()->prepare($query);
        return $pdo->execute();
    }

    public function insert(string $table, array $data)
    {
        $paramList = implode(", ", array_keys($data));
        $columnList = str_replace(':', '', $paramList);
        $query = "INSERT INTO $table($columnList) VALUES($paramList)";
        $pdo = $this->connection()->prepare($query);
        foreach($data as $key=>&$value)
        {
            $pdo->bindParam($key, $value);
        }
        $pdo->execute();
        return $this->connection()->lastInsertId();
    }

    public function update(string $table, array $data, string $where='')
    {
        $setsArray = [];
        foreach($data as $key=>$value)
        {
            $setsArray[] = $key.' = :'.$key;
        }
        $sets = implode( ', ', $setsArray);
        $query = "UPDATE $table SET $sets $where";
        $pdo = $this->connection()->prepare($query);
        foreach($data as $key=>&$value)
        {
            $pdo->bindParam($key, $value);
        }
        $pdo->execute();
    }

    private function connection()
    {
        return $this->databaseConnection->getConnection();
    }
}
