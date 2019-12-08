<?php

namespace App\Controller\admin;

use App\Entity\Exhibition;
use App\Form\ExhibitionType;
use App\Repository\ExhibitionRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExhibitionController extends AbstractController
{
    /**
     * @Route("/admin/exhibitionform", name="admin.exhibition.index")
     * @return Response
     */
    public function index(Request $request)
    {
        $type = ExhibitionType::class;
        $model = new Exhibition();

        $form = $this->createForm($type, $model);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $exhibition = new Exhibition();
            $data = $form->getData();

            $exhibition
                ->setName($data->getName())
                ->setPlace($data->getPlace())
                ->setDescription($data->getDescription())
                ->setDate($data->getDate())
            ;
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($exhibition);
            $manager->flush();

            //$this->addFlash('notice', 'Votre message a bien été envoyé, Tito Salgado y répondra aussi vite que possible');

            return $this->redirectToRoute('admin.exhibition.index');
        }

        return $this->render('admin/exhibition/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
