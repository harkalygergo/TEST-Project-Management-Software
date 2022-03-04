<?php

namespace App\View;

use App\Controller\AppController;
use App\Controller\ProjectController;
use App\Controller\StatusController;
use App\Model\Project;

class ProjectView
{
    public function __construct(
        private ?ProjectController $projectController = new ProjectController(),
        private ?StatusController $statusController = new StatusController(),
        private ?\Twig\Environment $twig = null
    )
    {
        $this->initTwig();
    }

    public function showProjects()
    {
        echo $this->twig->render('index.html.twig', [
            'projects' => $this->projectController->getProjects(),
            'statuses' => $this->statusController->getStatuses()
        ]);
    }

    public function edit(Project $project): void
    {
        echo $this->getEditForm($project);
    }

    private function getEditForm(Project $project)
    {
        return $this->twig->render('edit.html.twig', [
            'project' => $project,
            'statuses' => $this->statusController->getStatuses()
        ]);
    }

    private function initTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../../templates');
        $this->twig = new \Twig\Environment($loader,
            [
                'debug' => true,
            ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }
}
