<?php

declare(strict_types=1);

namespace Giphy\Core;

use Giphy\Controllers\RandomController;
use Giphy\Controllers\SearchController;
use Giphy\Controllers\TrendingController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected static Environment $view;

    public function __construct()
    {
        self::$view = new Environment(new FilesystemLoader(__DIR__ . '/../Views'));
    }

    public function random(): void
    {
        echo (new RandomController())->show(self::$view);
    }

    public function trending(): void
    {
        echo (new TrendingController())->show(self::$view);
    }

    public function search(): void
    {
        echo (new SearchController())->show(self::$view);
    }

    public function notFound(): void
    {
        echo self::$view->render('404.twig');
    }
}