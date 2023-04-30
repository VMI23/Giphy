<?php

declare(strict_types=1);

namespace Giphy\Controllers;

use Giphy\Models\GiphyClient;
use Twig\Environment;

class RandomController
{
    public function show(Environment $view)
    {
        $giphyClient = new GiphyClient();
        $gif = $giphyClient->getRandom();

        return $view->render('random.twig', ['gif' => $gif]);
    }
}