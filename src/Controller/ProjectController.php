<?php

namespace App\Controller;

use App\Model\Owner;
use App\Model\Project;
use App\Model\Status;

class ProjectController
{
    public function __construct(
        private ?DatabaseController $databaseConnection = null,
        private string              $databaseTable = 'projects'
    )
    {
        $this->db = new DatabaseController();
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
        return $this->db->getConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function new(): void
    {
        $project = new Project();

        $app = new AppController();
        $app->getEditForm($project);
    }

    public function edit(): void
    {
        $id = $_GET['id'];
        $project = $this->getProject($id);

        $app = new AppController();
        $app->getEditForm($project);
    }

    public function insert(array $data)
    {
        $paramList = implode(", ", array_keys($data));
        $columnList = str_replace(':', '', $paramList);
        $query = "INSERT INTO $this->databaseTable($columnList) VALUES($paramList)";
        $pdo = $this->db->getConnection()->prepare($query);
        foreach($data as $key=>&$value)
        {
            $pdo->bindParam($key, $value);
        }
        $pdo->debugDumpParams();
        $pdo->execute();
    }

    public function update(array $data, int $id)
    {
        $setsArray = [];
        foreach($data as $key=>$value)
        {
            $setsArray[] = $key.' = :'.$key;
        }
        $sets = implode( ', ', $setsArray);
        $query = "UPDATE ".$this->databaseTable." SET $sets WHERE id=:id";
        $pdo = $this->db->getConnection()->prepare($query);
        $pdo->bindParam(':id', $id);
        foreach($data as $key=>&$value)
        {
            $pdo->bindParam($key, $value);
        }
        $pdo->debugDumpParams();
        $pdo->execute();
    }

    public function save(?int $id)
    {
        $new = (is_null($id)) ? true : false;
        // insert
        if($new)
        {
            $data = [
                ':title' => $_POST['title'],
                ':description' => $_POST['description'],
            ];
            $this->insert($data);
        }
        // update
        else
        {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
            ];
            $this->update($data, $id);
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
            $this->db->getConnection()->query($query);
        }
        echo 'sikeres törlés';
    }
}
