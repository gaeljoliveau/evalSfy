<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage.index")
     */
    public function index(ArtworkRepository $artworkRepository, CategoryRepository $categoryRepository):Response
    {
        /*
         * repository : exclusivement pour les SELECT
         * méthode de récupération des résultats
         *   getResult: array d'entités
         *   getArrayResult : array de array
         *   getOneOrNullResult: un seul résultat
         *   getSingleScalarResult: un seul résultat scalaire(non complexe)
         *   getScalarResult: plusieurs résultats scalaires
         */
        //dd($productRepository->testDQL()->getResult());

        /*
         * getUser : récupération de l'utilisateur connecté
         * isGranted: test sur le rôle ou l'authentification d'un utilisateur
         * denyAccessUnlessGranted: bloquer une route à un rôle d'un certain niveau
         */
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //dd($this->isGranted('IS_AUTHENTICATED_FULLY'));


        $randomArtworks = $artworkRepository->get3randomArtworks();
        $categories = $categoryRepository->findAll();

        return $this->render('homepage/index.html.twig',[
            'randomArtworks' => $randomArtworks,
            'categories' => $categories
            ]);

        //return new Response("test");
        //return $this->render('homepage/test.html.twig');
    }


}
