<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Controller\AppController;

$app = new AppController();

if(isset($_GET['controller']))
{
    $action = (isset($_GET['action']) ? $_GET['action'] : '');
    switch($_GET['controller'])
    {
        case 'project':
        {
            $id = isset($_POST['id']) ? $_POST['id'] : (($_GET['id']!=='') ? $_GET['id'] : null);
            $projectController = new \App\Controller\ProjectController();
            $projectController->$action($id);
            break;
        }
    }
}
else
{
    $app->showProjects();
}
