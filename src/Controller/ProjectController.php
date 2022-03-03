<?php

namespace App\Controller;

class ProjectController
{
    public function __construct(
        private ?DatabaseConnection $databaseConnection = null
    )
    {
        $this->databaseConnection = new DatabaseConnection();
    }

    public function getProjects()
    {
        $query = "SELECT DISTINCT * FROM projects
            LEFT OUTER JOIN project_owner_pivot ON projects.id=project_owner_pivot.project_id
            INNER JOIN owners ON project_owner_pivot.owner_id=owners.id
            LEFT JOIN project_status_pivot ON projects.id=project_status_pivot.project_id
        ;";
        return $this->databaseConnection->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
