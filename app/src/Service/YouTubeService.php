<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class YouTubeService
{
    private const API_URL = 'https://www.googleapis.com/youtube/v3/search';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
        private CacheInterface $cache,
    ) {
    }

    public function searchTrailer(string $gameName): ?string
{
    return $this->cache->get('youtube_trailer_' . md5($gameName), function (ItemInterface $item) use ($gameName) {
        $item->expiresAfter(86400); // 1 jour

        $queries = [
            $gameName . ' bande-annonce officielle',
            $gameName . ' bande-annonce',
            $gameName . ' gameplay trailer',
        ];

        foreach ($queries as $query) {
            try {
                $response = $this->httpClient->request('GET', self::API_URL, [
                    'query' => [
                        'part' => 'snippet',
                        'q' => $query,
                        'type' => 'video',
                        'maxResults' => 3,
                        'videoEmbeddable' => 'true',
                        'videoSyndicated' => 'true',
                        'key' => $this->apiKey,
                    ],
                ]);

                $data = $response->toArray();

                foreach ($data['items'] ?? [] as $item) {
                    if (isset($item['id']['videoId'])) {
                        return 'https://www.youtube.com/embed/' . $item['id']['videoId'];
                    }
                }
            } catch (\Throwable $e) {}
        }

        return null;
    });
}
}
