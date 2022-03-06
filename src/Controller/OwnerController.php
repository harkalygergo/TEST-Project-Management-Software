<?php

namespace App\Controller;

use App\Model\Owner;
use App\Model\Status;

class OwnerController
{
    public function __construct(
        private ?DatabaseController $databaseConnection = null
    )
    {
        $this->databaseConnection = new DatabaseController();
    }

    public function getOwner($id): Owner
    {
        $owner = new Owner();

        $query = $this->getQuery($owner);
        $query .= " WHERE ".$owner::TABLE.".id=$id";
        $result = $this->databaseConnection->getConnection()->query($query)->fetch(\PDO::FETCH_ASSOC);

        $owner->setId($result['id']);
        $owner->setName($result['name']);
        $owner->setEmail($result['email']);

        return $owner;
    }

    private function getQuery($owner): string
    {
        return "SELECT DISTINCT * FROM ".$owner::TABLE;
    }
}
