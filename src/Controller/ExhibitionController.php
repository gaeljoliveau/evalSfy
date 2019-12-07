<?php

namespace App\Controller;

use App\Repository\ExhibitionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExhibitionController extends AbstractController
{
    /**
     * @Route("/exhibition", name="exhibition.index")
     * @param ExhibitionRepository $exhibitionRepository
     * @return Response
     */
    public function index(ExhibitionRepository $exhibitionRepository)
    {
        $result = $exhibitionRepository->getUpcomingExhibition();

        return $this->render('exhibition/index.html.twig', [
            'exhibitions' => $result
        ]);
    }
}
