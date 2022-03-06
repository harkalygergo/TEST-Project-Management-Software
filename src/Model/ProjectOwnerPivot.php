<?php

namespace App\Model;

class ProjectOwnerPivot
{
    const TABLE = 'project_owner_pivot';

    private ?int $owner_id = null;

    private ?int $status_id = null;

    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    public function setOwnerId(?int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    public function setStatusId(?int $status_id): void
    {
        $this->status_id = $status_id;
    }
}
