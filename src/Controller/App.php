<?php

namespace App\Controller;

require_once __DIR__.'/../../vendor/autoload.php';

class App
{
    private ?\Twig\Environment $twig = null;
    private ?ProjectController $projectController = null;

	public function __construct()
	{
        $this->projectController = new ProjectController();
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../../templates');
        $this->twig = new \Twig\Environment($loader);
    }

    public function listProjects()
    {
        echo $this->twig->render('index.html.twig', [
            'projects' => $this->projectController->getProjects()
        ]);
    }
}
(new App())->listProjects();
