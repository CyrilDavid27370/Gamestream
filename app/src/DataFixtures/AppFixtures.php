<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ===== GENRES =====
        // Genres adaptés au gaming (équivalents des genres films du CDC)
        $genresData = ['Action', 'Aventure', 'RPG', 'FPS', 'Stratégie'];
        $genres = [];

        foreach ($genresData as $name) {
            $genre = new Genre();
            $genre->setName($name);
            $manager->persist($genre);
            $genres[$name] = $genre;
        }

        // ===== GAMES =====
        // 3 jeux d'exemple avec genres variés

        // 1. Jeu d'Action
        $game1 = new Game();
        $game1->setRawgId(3498);
        $game1->setTitle('Grand Theft Auto V');
        $game1->setBackgroundImage('https://media.rawg.io/media/games/456/456dea5e1c7e3cd07060c14e96612001.jpg');
        $game1->setReleased(new \DateTime('2013-09-17'));
        $game1->setPlaytime(74);
        $game1->setPlatforms('PC, PlayStation 5, Xbox Series X');
        $game1->setOverview("Rockstar Games a mis la barre très haut avec GTA V. Los Santos, immense métropole inspirée de Los Angeles, fait vivre une aventure palpitante à travers trois protagonistes aux destins entremêlés.");
        $game1->setDescription('Un classique incontournable du monde ouvert.');
        $game1->setIsPlayed(true);
        $game1->setGenre($genres['Action']);
        $manager->persist($game1);

        // 2. Jeu de RPG
        $game2 = new Game();
        $game2->setRawgId(3328);
        $game2->setTitle('The Witcher 3: Wild Hunt');
        $game2->setBackgroundImage('https://media.rawg.io/media/games/618/618c2031a07bbff6b4f611f10b6bcdbc.jpg');
        $game2->setReleased(new \DateTime('2015-05-18'));
        $game2->setPlaytime(46);
        $game2->setPlatforms('PC, PlayStation 5, Xbox Series X, Nintendo Switch');
        $game2->setOverview("Dans un monde de dark fantasy, incarnez Geralt de Riv, sorceleur chasseur de monstres, à la recherche de Ciri, enfant de prophétie traquée par la Chasse Sauvage.");
        $game2->setDescription(null);
        $game2->setIsPlayed(false);
        $game2->setGenre($genres['RPG']);
        $manager->persist($game2);

        // 3. Jeu de FPS
        $game3 = new Game();
        $game3->setRawgId(4200);
        $game3->setTitle('Portal 2');
        $game3->setBackgroundImage('https://media.rawg.io/media/games/2ba/2bac0e87cf45e5b508f227d281c9252a.jpg');
        $game3->setReleased(new \DateTime('2011-04-18'));
        $game3->setPlaytime(11);
        $game3->setPlatforms('PC, PlayStation 3, Xbox 360');
        $game3->setOverview("Dans ce puzzle-game à la première personne, vous utilisez un pistolet à portails pour résoudre des énigmes dans les laboratoires d'Aperture Science, sous l'oeil malicieux de GLaDOS.");
        $game3->setDescription(null);
        $game3->setIsPlayed(false);
        $game3->setGenre($genres['FPS']);
        $manager->persist($game3);

        // Enregistrement en base
        $manager->flush();
    }
}
