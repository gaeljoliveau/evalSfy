<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/artwork", name="artwork.index")
     */
    public function index(ArtworkRepository $repository, CategoryRepository $categoryRepository):Response
        {
            $categories = $categoryRepository->findAll();

            $result = $repository->findAll();
            return $this->render('artwork/index.html.twig',[
                'artworks' => $result,
                'categories' => $categories
            ]);
    }

    /**
     * @Route("/artwork/category/{catId}", name="artwork.indexfiltered")
     */
    public function indexfiltered(ArtworkRepository $repository, CategoryRepository $categoryRepository, int $catId ):Response{

        $categories = $categoryRepository->findAll();
        $cat = $categoryRepository->find($catId);

        $result = $repository->findBy([
            'category' => $cat
        ]);

        return $this->render('artwork/index.html.twig',[
            'artworks' => $result,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/artworkdetail/{id}", name="artwork.detail")
     */
    public function detail(ArtworkRepository $artworkRepository,int $id):Response
    {
        $result = $artworkRepository->find($id);

        return $this->render('artwork/artwork.html.twig',[
            'artwork' => $result
        ]);
    }
}
