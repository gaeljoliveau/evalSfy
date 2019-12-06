<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/artwork", name="artwork.index")
     */
    public function index(ArtworkRepository $repository ):Response
        {
            $result = $repository->findAll();
            return $this->render('artwork/index.html.twig',[
                'artworks' => $result
            ]);
    }

    /**
     * @Route("/artwork/{id}", name="artwork/detail")
     */
    public function detail(ArtworkRepository $artworkRepository,int $id):Response
    {
        $result = $artworkRepository->findOneBy([
           'id' => $id
        ]);
        return $this->render('artwork/index.html.twig',[
            'artworks' => $result
        ]);
    }
}
