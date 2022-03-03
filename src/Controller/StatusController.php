<?php

namespace App\Controller;

class StatusController
{
    public function __construct(
        private ?DatabaseConnection $databaseConnection = null
    )
    {
        $this->databaseConnection = new DatabaseConnection();
    }

    public function getStatuses(): array
    {
        $query = "SELECT DISTINCT id, name FROM statuses;";
        $statuses = $this->databaseConnection->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        $results = [];
        foreach($statuses as $status)
        {
            $results[$status['id']] = $status['name'];
        }

        return $results;
    }
}
