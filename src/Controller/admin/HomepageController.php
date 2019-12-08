<?php

namespace App\Controller\admin;

use App\Entity\Artwork;
use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.homepage.index")
     */
    public function index(ArtworkRepository $artworkRepository, CategoryRepository $categoryRepository):Response
    {

        return $this->render('admin/homepage/index.html.twig');

        //return new Response("test");
        //return $this->render('homepage/test.html.twig');
    }


}
