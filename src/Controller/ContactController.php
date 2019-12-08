<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact.index")
     */
    public function index(Request $request )
    {
        $type = ContactType::class;
        $model = new Contact();

        $form = $this->createForm($type, $model);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contact = new Contact();
            $data = $form->getData();

            $contact
                ->setName($data->getName())
                ->setEmail($data->getEmail())
                ->setMessage($data->getMessage())
            ;
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($contact);
            $manager->flush();

            //$this->addFlash('notice', 'Votre message a bien été envoyé, Tito Salgado y répondra aussi vite que possible');

            return $this->redirectToRoute('contact.index');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
