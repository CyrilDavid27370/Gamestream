<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/', name: 'app_game_index')]
    public function index(Request $request, GameRepository $gameRepository, GenreRepository $genre): Response
    {
        $genreId = $request->query->get('genre');
        $playedFilter = $request->query->get('played');

        $criteria = [];
        if ($genreId) {
            $criteria['genre'] = $genreId;
        }

        if ($playedFilter !== null) {
            $criteria['isPlayed'] = $playedFilter === '1';
        }

        $games = $gameRepository->findBy($criteria);

        return $this->render('game/index.html.twig', [
            'games' => $games,
            'genres' => $genre->findAll(),
            'selectedGenre' => $genreId,
            'playedFilter' => $playedFilter,
        ]);
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show (Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }
}
