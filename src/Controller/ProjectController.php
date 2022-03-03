<?php

namespace App\Controller;

use App\Model\Project;

class ProjectController
{
    public function __construct(
        private ?DatabaseConnection $databaseConnection = null,
        private string $databaseTable = 'projects'
    )
    {
        $this->db = new DatabaseConnection();
    }

    private function getQuery(): string
    {
        return "SELECT DISTINCT projects.*, owners.name, owners.email, project_status_pivot.status_id, project_owner_pivot.owner_id FROM projects
            LEFT JOIN project_owner_pivot ON projects.id=project_owner_pivot.project_id
            LEFT JOIN owners ON project_owner_pivot.owner_id=owners.id
            LEFT JOIN project_status_pivot ON projects.id=project_status_pivot.project_id
        ";
    }

    public function getProject(int $id): Project
    {
        $query = $this->getQuery();
        $query .= " WHERE projects.id=$id";
        $result = $this->db->getConnection()->query($query)->fetch(\PDO::FETCH_ASSOC);

        $statusController = new StatusController();
        $status = $statusController->getStatus($result['status_id']);

        $ownerController = new OwnerController();
        $owner = $ownerController->getOwner($result['owner_id']);

        $project = new Project();
        $project->setId($result['id']);
        $project->setTitle($result['title']);
        $project->setDescription($result['description']);
        $project->setStatus($status);
        $project->setOwner($owner);

        return $project;
    }

    public function getProjects()
    {
        $query = $this->getQuery();
        return $this->db->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function edit()
    {
        $id = $_GET['id'];
        $project = $this->getProject($id);

        $app = new AppController();
        $app->getEditForm($project);
    }

    public function save()
    {

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
