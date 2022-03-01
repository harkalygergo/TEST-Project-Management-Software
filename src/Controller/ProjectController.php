<?php

namespace App\Controller;

class ProjectController
{
    private ?DatabaseConnection $databaseConnection = null;

    public function __construct()
    {
        $this->databaseConnection = new DatabaseConnection();
    }

    public function getProjects()
    {
        return $this->databaseConnection->getConnection()->query("SELECT * FROM projects")->fetchAll();
    }
}
