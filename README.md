# 🎮 GameStream

> **Votre ludotheque personnelle, partout, a tout moment.**

GameStream est une application web multi-utilisateurs developpee avec **Symfony 7** qui permet a chaque utilisateur de constituer, organiser et annoter sa propre collection de jeux video, en s'appuyant sur les APIs **RAWG** et **YouTube**.

Ce projet est inspire du cahier des charges **CineStream+** (plateforme de VOD), adapte a l'univers du jeu video.

## Fonctionnalites

### V1 - Fonctionnalites de base
- Ludotheque personnelle : ajouter, consulter, modifier et supprimer des jeux
- Recherche de jeux via l'API RAWG
- Filtrage par genre et par statut (Joue / A jouer)
- Modification personnalisee : genre, description, statut
- Suppression avec confirmation JavaScript
- Protection CSRF sur toutes les actions
- Responsive Design (mobile first)
- Theme sombre gaming : Bootstrap Vapor

### V2 - Fonctionnalites avancees
- Notation personnelle par note sur 10
- Double affichage : cartes ou tableau
- CRUD complet des categories personnalisees (methode save unifiee)
- Bande-annonce YouTube avec strategie de fallback intelligente
  - Priorite 1 : trailer MP4 de RAWG si disponible
  - Priorite 2 : URL YouTube stockee en BDD (cache)
  - Priorite 3 : recherche automatique via API YouTube + sauvegarde
- Authentification complete (inscription, connexion, deconnexion, remember me)
- Ludotheque privee par utilisateur avec isolation des donnees
- Protection d'acces : impossibilite de voir/modifier les jeux d'un autre utilisateur

## Stack technique

- Back-end : PHP 8.2 + Symfony 7.4
- Base de donnees : MySQL 8
- ORM : Doctrine
- Front-end : Twig + Bootstrap 5.3 (Vapor)
- Serveur web : Nginx (Alpine)
- Conteneurisation : Docker + Docker Compose
- Securite : Symfony Security Bundle (bcrypt)
- Cache : Symfony Cache Component
- APIs externes : RAWG API, YouTube Data API v3

## Prerequis

- Docker + Docker Compose
- Git
- Un compte sur rawg.io/apidocs pour une cle API gratuite
- Une cle API YouTube Data v3 (Google Cloud Console)

## Installation

1. Cloner le depot :

    git clone https://github.com/CyrilDavid/gamestream.git
    cd gamestream

2. Lancer les conteneurs Docker :

    docker compose up -d --build

3. Installer les dependances :

    docker exec -ti gamestream_php sh
    composer install

4. Creer la base de donnees :

    php bin/console doctrine:database:create --if-not-exists
    php bin/console doctrine:migrations:migrate

5. Charger les fixtures (5 genres de demo) :

    php bin/console doctrine:fixtures:load

## Configuration des cles API

Cree le fichier app/.env.local avec :

    RAWG_API_KEY=ta_cle_rawg_ici
    YOUTUBE_API_KEY=ta_cle_youtube_ici

Ce fichier est ignore par Git pour la securite.

## Premiere utilisation

1. Rendez-vous sur http://localhost:8080
2. Vous serez redirige vers la page de connexion
3. Cliquez sur "S'inscrire" pour creer votre premier compte
4. Apres inscription, vous etes automatiquement connecte
5. Votre ludotheque est vide : utilisez la recherche pour ajouter votre premier jeu !

## Acces aux services

- GameStream : http://localhost:8080
- PhpMyAdmin : http://localhost:8081

Identifiants MySQL : admin / password / gamestream

## Architecture du projet

- src/Controller/ : GameController, SearchController, GenreController, SecurityController, RegistrationController
- src/Entity/ : User, Game, Genre
- src/Form/ : GameType, GenreType, RegistrationFormType
- src/Service/ : RawgService, YouTubeService (avec cache Symfony)
- src/Repository/ : repositories Doctrine
- templates/ : base.html.twig centralise header/navbar/footer, templates specifiques par page

## Choix techniques

**Symfony 7** : framework moderne pour structurer une architecture MVC robuste avec composants Forms, Security, Doctrine, HttpClient.

**Docker** : environnement reproductible, 4 conteneurs orchestres (nginx, php-fpm, mysql, phpmyadmin).

**Bootstrap Vapor** : theme sombre gaming, installe en local pour fonctionner hors ligne.

**RAWG API** : base de donnees de jeux video la plus complete et gratuite.

**YouTube Data API v3** : recherche automatique de bandes-annonces avec cache 24h pour limiter les appels API.

**Securite** :
- Tokens CSRF sur toutes les actions POST
- Mots de passe hashes avec bcrypt
- Cles API dans .env.local (non committe)
- Requetes preparees Doctrine (prevention SQL injection)
- Echappement automatique Twig (prevention XSS)
- Isolation des donnees par utilisateur
- Protection d'acces aux ressources (AccessDeniedException)

**Pattern Service** : RawgService et YouTubeService pour separer la logique metier de l'API.

**Injection de dependances** : autowiring Symfony pour tous les controllers et services.

## Roadmap V3 (idees futures)

- Export de la ludotheque en PDF
- Partage de ludotheque entre amis
- Statistiques personnelles (temps de jeu total, genres preferes)
- Recommandations de jeux basees sur la collection
- Mode hors ligne (PWA)

## Auteur

**Cyril David**  
Developpeur Web et Web Mobile en formation - Hunik Academy  
Projet realise en avril 2026.

## Licence

Projet realise dans un cadre pedagogique. Usage non commercial.  
Donnees des jeux fournies par RAWG (rawg.io).  
Videos fournies par YouTube (youtube.com).
