<?php

namespace App\Controller;

use App\Service\RawgService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, RawgService $rawgService): Response
    {

            $query = $request->query->get('q');
            $games = [];

            if ($query) {
                $games = $rawgService->searchGames($query);
            }

    return $this->render('search/index.html.twig', [
            'query' => $query,
            'games' => $games,
        ]);
    }

    #[Route('/search/{rawgId}', name: 'app_search_show', requirements: ['rawgId' => '\d+'])]
    public function show(int $rawgId, RawgService $rawgService): Response
    {
        $game = $rawgService->getGameById($rawgId);

        return $this->render('search/show.html.twig', [
            'game' => $game,
        ]);
    }
}
