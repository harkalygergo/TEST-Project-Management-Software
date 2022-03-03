<?php

namespace App\Controller;

use App\Model\Status;

class StatusController
{
    public function __construct(
        private ?DatabaseConnection $databaseConnection = null,
        private string $databaseTable = 'statuses'
    )
    {
        $this->databaseConnection = new DatabaseConnection();
    }

    private function getQuery(): string
    {
        return "SELECT DISTINCT * FROM ".$this->databaseTable;
    }

    public function getStatus($id): Status
    {
        $query = $this->getQuery();
        $query .= " WHERE ".$this->databaseTable.".id=$id";
        $result = $this->databaseConnection->getConnection()->query($query)->fetch(\PDO::FETCH_ASSOC);

        $status = new Status();
        $status->setId($id);
        $status->setName($result['name']);
        $status->setKey($result['key']);

        return $status;
    }

    public function getStatuses(): array
    {
        $query = $this->getQuery();
        $statuses = $this->databaseConnection->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        $results = [];
        foreach($statuses as $status)
        {
            $results[$status['id']] = $status['name'];
        }

        return $results;
    }
}
