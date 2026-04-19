<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\RawgService;
use App\Service\YouTubeService;
use Doctrine\ORM\EntityManagerInterface;
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
public function show(
    int $rawgId,
    RawgService $rawgService,
    YouTubeService $youTubeService,
    GameRepository $gameRepository,
    EntityManagerInterface $em
): Response {
    $gameData = $rawgService->getGameById($rawgId);
    $movies = $rawgService->getGameMovies($rawgId);

    $gameEntity = $gameRepository->findOneBy(['rawgId' => $rawgId]);
    $youtubeTrailer = null;

    if ($gameEntity && $gameEntity->getYoutubeUrl()) {
        $youtubeTrailer = $gameEntity->getYoutubeUrl();
    } elseif (empty($movies)) {
        $youtubeTrailer = $youTubeService->searchTrailer($gameData['name']);

        if ($youtubeTrailer && $gameEntity) {
            $gameEntity->setYoutubeUrl($youtubeTrailer);
            $em->flush();
        }
    }

    return $this->render('search/show.html.twig', [
        'game' => $gameData,
        'movies' => $movies,
        'youtubeTrailer' => $youtubeTrailer,
    ]);
}
    #[Route('/search/{rawgId}/add', name: 'app_search_add', requirements: ['rawgId' => '\d+'], methods: ['POST'])]
    public function add(
        int $rawgId,
        Request $request,
        RawgService $rawgService,
        YouTubeService $youTubeService,
        GameRepository $gameRepository,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('add_game_' . $rawgId, $request->request->get('_token'))) {
            $this->addFlash('danger', 'Token invalide.');
            return $this->redirectToRoute('app_search');
        }

        $existingGame = $gameRepository->findOneBy([
            'rawgId' => $rawgId,
            'user' =>$this->getUser(),
        ]);

        $existingGame = $gameRepository->findOneBy(['rawgId' => $rawgId]);
        if ($existingGame) {
            $this->addFlash('warning', 'Ce jeu est déjà dans votre ludothèque.');
            return $this->redirectToRoute('app_game_show', ['id' => $existingGame->getId()]);
        }

        $data = $rawgService->getGameById($rawgId);

        $game = new Game();
        $game->setRawgId($data['id']);
        $game->setTitle($data['name']);
        $game->setBackgroundImage($data['background_image'] ?? null);
        $game->setReleased(isset($data['released']) ? new \DateTime($data['released']) : null);
        $game->setPlaytime($data['playtime'] ?? null);
        $game->setOverview($data['description_raw'] ?? null);
        $game->setUser($this->getUser());

        if (!empty($data['platforms'])) {
            $platformNames = array_map(fn($p) => $p['platform']['name'], $data['platforms']);
            $game->setPlatforms(implode(', ', $platformNames));
        }

        $game->setIsPlayed(false);
        $game->setDescription(null);

        $youtubeTrailer = $youTubeService->searchTrailer($data['name']);
        $game->setYoutubeUrl($youtubeTrailer);

        $game->setUser($this->getUser());

        $entityManager->persist($game);
        $entityManager->flush();

        $this->addFlash('success', 'Le jeu "' . $game->getTitle() . '" a été ajouté à votre ludothèque !');

        return $this->redirectToRoute('app_game_update', ['id' => $game->getId()]);
    }
}
