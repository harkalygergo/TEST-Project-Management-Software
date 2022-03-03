<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Controller\AppController;

$app = new AppController();
$app->show_errors();
$app->listProjects();
