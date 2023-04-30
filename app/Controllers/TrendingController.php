<?php

declare(strict_types=1);

namespace Giphy\Controllers;

use Giphy\Models\GiphyClient;
use Twig\Environment;

class TrendingController
{
    public function show(Environment $view)
    {
        $giphyClient = new GiphyClient();
        $gifs = $giphyClient->getTrending();

        return empty($gifs) ? $view->render('404.twig') : $view->render('trending.twig', ['gifs' => $gifs]);
    }
}