<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Contact1Type;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(EntityManagerInterface $em, Request $request):Response
    {

        $form = $this->createForm(Contact1Type::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $Contact = $form->getData();
            $Contact->setStatut('reçu');
            $em->persist($Contact);
            $em->flush();


            $this->addFlash('success', 'merci pour votre prise de contact');
            return $this->redirectToRoute('contact');
        }


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'controller_title' => 'contact',
            'form' => $form->createView(),

            
        ]);
    }





}
