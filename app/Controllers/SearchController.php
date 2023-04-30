<?php

declare(strict_types=1);

namespace Giphy\Controllers;

use Giphy\Models\GiphyClient;
use Twig\Environment;

class SearchController
{
    public function show(Environment $view)
    {
        $giphyClient = new GiphyClient();
        $query = urlencode($_GET['search']);
        $limit = (int)urlencode($_GET['count']);

        $gifs = $giphyClient->getSearched($query, $limit);

        return empty($gifs) ? $view->render('404.twig') : $view->render(
            'searched.twig', ['gifs' => $gifs, 'query' => $query]
        );
    }
}