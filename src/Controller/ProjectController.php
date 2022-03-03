<?php

namespace App\Controller;

class ProjectController
{
    public function __construct(
        private ?DatabaseConnection $databaseConnection = null
    )
    {
        $this->db = new DatabaseConnection();
    }

    public function getProjects()
    {
        $query = "SELECT DISTINCT projects.*, owners.name, owners.email, project_status_pivot.status_id FROM projects
            LEFT JOIN project_owner_pivot ON projects.id=project_owner_pivot.project_id
            LEFT JOIN owners ON project_owner_pivot.owner_id=owners.id
            LEFT JOIN project_status_pivot ON projects.id=project_status_pivot.project_id;
        ;";
        return $this->db->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function edit()
    {
        $app = new AppController();
        $app->editForm();
    }

    public function delete(int $id)
    {
        $queries = [
            "DELETE FROM project_status_pivot WHERE project_id=$id;",
            "DELETE FROM project_owner_pivot WHERE project_id=$id;",
            "DELETE FROM projects WHERE id=$id"
        ];
        foreach($queries as $query)
        {
            $this->db->getConnection()->query($query);
        }
        echo 'sikeres törlés';
    }
}
