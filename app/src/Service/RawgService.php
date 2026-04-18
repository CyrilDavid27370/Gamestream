<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RawgService
{
    // URL de base de l'API RAWG
    private const API_URL = 'https://api.rawg.io/api';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey
    ) {
    }

    /**
     * Recherche des jeux par titre
     * @return array Liste des jeux trouvés
     */
    public function searchGames(string $query): array
    {
        $response = $this->httpClient->request('GET', self::API_URL . '/games', [
            'query' => [
                'key' => $this->apiKey,
                'search' => $query,
                'page_size' => 20,
            ],
        ]);

        $data = $response->toArray();

        return $data['results'] ?? [];
    }

    /**
     * Récupère les détails complets d'un jeu par son ID RAWG
     * @return array Détails complets du jeu
     */
    public function getGameById(int $rawgId): array
    {
        $response = $this->httpClient->request('GET', self::API_URL . '/games/' . $rawgId, [
            'query' => [
                'key' => $this->apiKey,
            ],
        ]);

        return $response->toArray();
    }
}
