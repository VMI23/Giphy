<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/bootstrap.php';

use Giphy\Core\Controller;
use Giphy\Core\Router;

// Initialize controller

$router = new Router();

$router->dispatch();