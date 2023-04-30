<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';


// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

