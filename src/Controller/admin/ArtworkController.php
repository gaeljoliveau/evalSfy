<?php

namespace App\Controller\admin;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/admin/artwork", name="admin.artwork.index")
     */
    public function index(ArtworkRepository $repository):Response
    {

            $result = $repository->findAll();
            return $this->render('admin/artwork/index.html.twig',[
                'artworks' => $result
            ]);
    }

    /**
     * @Route("/admin/artworkdetail/{id}", name="admin.artwork.update")
     * @Route("/admin/form", name="admin.artwork.form")
     */
    public function detail(ArtworkRepository $artworkRepository,int $id = null,Request $request, EntityManagerInterface $entityManager):Response
    {
        $model = $id ? $artworkRepository->find($id) : new Artwork();
        $type = ArtworkType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $model->getId() ? null : $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('admin.artwork.index');
        }

        return $this->render('admin/artwork/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
