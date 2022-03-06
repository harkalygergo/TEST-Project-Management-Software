<?php

namespace App\Model;

class ProjectStatusPivot
{
    const TABLE = 'project_status_pivot';

    private ?int $project_id = null;

    private ?int $status_id = null;

    public function getProjectId(): ?int
    {
        return $this->project_id;
    }

    public function setProjectId(?int $project_id): void
    {
        $this->project_id = $project_id;
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
