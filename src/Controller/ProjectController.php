<?php

namespace App\Controller;

use App\Manager\DatabaseManager;
use App\Model\Owner;
use App\Model\Project;
use App\Model\ProjectStatusPivot;
use App\Model\Status;

class ProjectController
{
    public function __construct(
        private ?DatabaseController $databaseController = new DatabaseController(),
        private ?DatabaseManager $databaseManager = new DatabaseManager()
    ) {}

    public function getProject(int $id): Project
    {
        $query = $this->getQuery();
        $query .= " WHERE projects.id=$id";
        $result = $this->databaseController->getConnection()->query($query)->fetch(\PDO::FETCH_ASSOC);

        $statusController = new StatusController();
        $ownerController = new OwnerController();
        $status = (!is_null($result['status_id'])) ? $statusController->getStatus($result['status_id']) : new Status();
        $owner = (!is_null($result['owner_id'])) ? $ownerController->getOwner($result['owner_id']) : new Owner();

        $project = new Project();
        $project->setId($result['id']);
        $project->setTitle($result['title']);
        $project->setDescription($result['description']);
        $project->setStatus($status);
        $project->setOwner($owner);

        return $project;
    }

    public function getProjects(): array
    {
        $query = $this->getQuery();
        return $this->databaseController->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function new(): void
    {
        $project = new Project();

        $app = new AppController();
        $app->getEditForm($project);
    }

    public function edit(): void
    {
        $project = $this->getProject($_GET['id']);

        $app = new AppController();
        $app->getEditForm($project);
    }

    public function save(?int $id)
    {
        $project = new Project();

        $new = (is_null($id)) ? true : false;
        $projectStatusPivot = new ProjectStatusPivot();
        // insert
        if($new)
        {
            // save project
            $data = [
                ':title' => $_POST['title'],
                ':description' => $_POST['description'],
            ];
            $lastInsertId = $this->databaseManager->insert($project::TABLE, $data);

            // status pivot
            $data = [
                ':project_id' => $lastInsertId,
                ':status_id' => $_POST['status'],
            ];
            $lastInsertId = $this->databaseManager->insert($projectStatusPivot::TABLE, $data);
        }
        // update
        else
        {
            // save project
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
            ];
            $this->databaseManager->update($project::TABLE, $data, ' WHERE id='.$id);

            // status pivot
            $currentStatus = $this->getProject($id)->getStatus()->getId();
            $data = [
                'project_id' => $id,
                'status_id' => $_POST['status'],
            ];
            $this->databaseManager->update($projectStatusPivot::TABLE, $data, " WHERE project_id=$id AND status_id=$currentStatus");
        }
        header('Location:/');
    }

    public function delete(int $id): void
    {
        $queries = [
            "DELETE FROM project_status_pivot WHERE project_id=$id;",
            "DELETE FROM project_owner_pivot WHERE project_id=$id;",
            "DELETE FROM projects WHERE id=$id"
        ];
        foreach($queries as $query)
        {
            $this->databaseController->getConnection()->query($query);
        }
        echo 'sikeres törlés';
    }

    private function getQuery(): string
    {
        return "SELECT DISTINCT projects.*, owners.name, owners.email, project_status_pivot.status_id, project_owner_pivot.owner_id FROM projects
            LEFT JOIN project_owner_pivot ON projects.id=project_owner_pivot.project_id
            LEFT JOIN owners ON project_owner_pivot.owner_id=owners.id
            LEFT JOIN project_status_pivot ON projects.id=project_status_pivot.project_id
        ";
    }
}
