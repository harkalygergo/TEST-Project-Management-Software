<?php

namespace App\Controller;

use App\Model\Project;
use App\View\ProjectView;

class AppController
{
    public function __construct(
        private ?ProjectView $projectView = new ProjectView(),
        private ?StatusController $statusController = null,
        private ?OwnerController $ownerController = new OwnerController(),
        private ?\Twig\Environment $twig = null
    )
    {
        $this->statusController = new StatusController();
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../../templates');
        $this->twig = new \Twig\Environment($loader,
        [
            'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function getEditForm(Project $project)
    {
        echo $this->twig->render('edit.html.twig', [
            'project' => $project,
            'statuses' => $this->statusController->getStatuses(),
            'owners' => $this->ownerController->getOwners()
        ]);
    }

    public function showProjects()
    {
        $this->projectView->showProjects();
    }
}
