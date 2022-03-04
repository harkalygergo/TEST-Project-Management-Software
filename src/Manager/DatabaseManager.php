<?php

namespace App\Manager;

use App\Controller\DatabaseController;

class DatabaseManager
{
    public function __construct(
        private ?DatabaseController $databaseConnection = new DatabaseController()
    ) {}

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
    }

    public function update(string $table, array $data, int $id)
    {
        $setsArray = [];
        foreach($data as $key=>$value)
        {
            $setsArray[] = $key.' = :'.$key;
        }
        $sets = implode( ', ', $setsArray);
        $query = "UPDATE $table SET $sets WHERE id=:id";
        $pdo = $this->connection()->prepare($query);
        $pdo->bindParam(':id', $id);
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
