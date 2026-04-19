<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GenreController extends AbstractController
{
    // LISTER les catégories
    #[Route('/genres', name: 'app_genre_index')]
    public function index(GenreRepository $genreRepository): Response
    {
        return $this->render('genre/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

    // CRÉER ou MODIFIER (même méthode grâce à 2 routes et un paramètre optionnel)
    #[Route('/genres/new', name: 'app_genre_new')]
    #[Route('/genres/{id}/edit', name: 'app_genre_edit', requirements: ['id' => '\d+'])]
    public function save(
        Request $request,
        EntityManagerInterface $entityManager,
        ?Genre $genre = null
    ): Response {
        // Si pas de genre (route /new) → on en crée un nouveau
        $isNew = $genre === null;
        if ($isNew) {
            $genre = new Genre();
        }

        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // persist uniquement pour une création
            if ($isNew) {
                $entityManager->persist($genre);
            }
            $entityManager->flush();

            $message = $isNew
                ? 'La catégorie "' . $genre->getName() . '" a été créée.'
                : 'La catégorie "' . $genre->getName() . '" a été mise à jour.';

            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_genre_index');
        }

        return $this->render('genre/save.html.twig', [
            'genre' => $genre,
            'form' => $form,
            'isNew' => $isNew,
        ]);
    }

    // SUPPRIMER avec token CSRF
    #[Route('/genres/{id}/delete', name: 'app_genre_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_genre_' . $genre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($genre);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie "' . $genre->getName() . '" a été supprimée.');
        }

        return $this->redirectToRoute('app_genre_index');
    }
}
