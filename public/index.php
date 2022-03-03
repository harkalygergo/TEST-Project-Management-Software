<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Controller\AppController;

$app = new AppController();
$app->show_errors();

if(isset($_GET['controller']))
{
    $action = (isset($_GET['action']) ? $_GET['action'] : '');
    switch($_GET['controller'])
    {
        case 'project':
        {
            $projectController = new \App\Controller\ProjectController();
            $projectController->$action($_POST['id']);
            break;
        }
    }
}
else
{
    $app->listProjects();
}
