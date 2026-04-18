# 🎮 GameStream

> Votre ludotheque personnelle, partout, a tout moment.

GameStream est une application web developpee avec Symfony 7 qui permet de constituer, organiser et annoter sa propre collection de jeux video, en s'appuyant sur l'API RAWG.

Ce projet est inspire du cahier des charges CineStream+ (plateforme de VOD), adapte a l'univers du jeu video.

## Fonctionnalites

- Ludotheque personnelle : ajouter, consulter, modifier et supprimer des jeux
- Recherche de jeux via l'API RAWG
- Filtrage par genre et par statut (Joue / A jouer)
- Modification personnalisee : genre, description, statut
- Suppression avec confirmation JavaScript
- Protection CSRF sur toutes les actions
- Responsive Design (mobile first)
- Theme sombre gaming : Bootstrap Vapor

## Stack technique

- Back-end : PHP 8.2 + Symfony 7.4
- Base de donnees : MySQL 8
- ORM : Doctrine
- Front-end : Twig + Bootstrap 5.3 (Vapor)
- Serveur web : Nginx (Alpine)
- Conteneurisation : Docker + Docker Compose
- API externe : RAWG API

## Prerequis

- Docker + Docker Compose
- Git
- Un compte sur rawg.io/apidocs pour une cle API gratuite

## Installation

1. Cloner le depot : git clone puis cd gamestream
2. Lancer les conteneurs : docker compose up -d --build
3. Entrer dans le conteneur PHP : docker exec -ti gamestream_php sh
4. Installer les dependances : composer install
5. Creer la base : php bin/console doctrine:database:create --if-not-exists
6. Jouer les migrations : php bin/console doctrine:migrations:migrate
7. Charger les fixtures : php bin/console doctrine:fixtures:load

## Configuration de la cle API RAWG

Cree le fichier app/.env.local avec :

RAWG_API_KEY=ta_cle_api_ici

Ce fichier est ignore par Git.

## Acces aux services

- GameStream : http://localhost:8080
- PhpMyAdmin : http://localhost:8081

Identifiants MySQL : admin / password / gamestream

## Choix techniques

Symfony 7 pour la robustesse, Docker pour un environnement reproductible, Bootstrap Vapor pour le theme gaming, RAWG pour les donnees de jeux. Securite via tokens CSRF, clef API dans .env.local, requetes preparees Doctrine, echappement Twig automatique.

## Roadmap V2

- Notation par etoiles
- Lecteur de trailer YouTube
- Gestion des categories personnalisees (CRUD)
- Authentification et ludotheque par utilisateur

## Auteur

Cyril David - Developpeur Web et Web Mobile en formation a Hunik Academy.
Projet realise en avril 2026.

## Licence

Projet pedagogique. Donnees fournies par RAWG.
