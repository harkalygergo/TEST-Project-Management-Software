<?php

namespace App\Controller;

use App\Model\Owner;
use App\Model\Status;

class OwnerController
{
    public function __construct(
        private ?DatabaseConnection $databaseConnection = null,
        private string $databaseTable = 'owners'
    )
    {
        $this->databaseConnection = new DatabaseConnection();
    }

    private function getQuery(): string
    {
        return "SELECT DISTINCT * FROM ".$this->databaseTable;
    }

    public function getOwner($id): Owner
    {
        $query = $this->getQuery();
        $query .= " WHERE ".$this->databaseTable.".id=$id";
        $result = $this->databaseConnection->getConnection()->query($query)->fetch(\PDO::FETCH_ASSOC);

        $owner = new Owner();
        $owner->setId($result['id']);
        $owner->setName($result['name']);
        $owner->setEmail($result['email']);

        return $owner;
    }
}
