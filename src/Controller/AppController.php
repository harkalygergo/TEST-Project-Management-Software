<?php

namespace App\Controller;

class AppController
{
    public function __construct(
        private ?ProjectController $projectController = null,
        private ?StatusController $statusController = null,
        private ?\Twig\Environment $twig = null
    )
    {
        $this->projectController = new ProjectController();
        $this->statusController = new StatusController();
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../../templates');
        $this->twig = new \Twig\Environment($loader,
        [
            'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function editForm()
    {
        echo $this->twig->render('edit.html.twig', [
            'project' => [],
            'statuses' => $this->statusController->getStatuses()
        ]);
    }

    public function listProjects()
    {
        echo $this->twig->render('index.html.twig', [
            'projects' => $this->projectController->getProjects(),
            'statuses' => $this->statusController->getStatuses()
        ]);
    }

    public function show_errors()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    public function hide_errors()
    {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}
