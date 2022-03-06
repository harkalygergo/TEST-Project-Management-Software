<?php

namespace App\Controller;

use App\Model\Status;

class StatusController
{
    public function __construct(
        private ?DatabaseController $databaseConnection = null,
        private string              $databaseTable = 'statuses'
    )
    {
        $this->databaseConnection = new DatabaseController();
    }

    public function getStatus($id): Status
    {
        $status = new Status();

        $query = $this->getQuery($status);
        $query .= " WHERE ".$this->databaseTable.".id=$id";
        $result = $this->databaseConnection->getConnection()->query($query)->fetch(\PDO::FETCH_ASSOC);

        $status->setId($id);
        $status->setName($result['name']);
        $status->setKey($result['key']);

        return $status;
    }

    public function getStatuses(): array
    {
        $status = new Status();

        $query = $this->getQuery($status);
        $statuses = $this->databaseConnection->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        $results = [];
        foreach($statuses as $status)
        {
            $results[$status['id']] = $status['name'];
        }

        return $results;
    }

    private function getQuery($status): string
    {
        return "SELECT DISTINCT * FROM ".$status::TABLE;
    }
}
