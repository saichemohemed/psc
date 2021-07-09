<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Evenement;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em, Request $request):Response
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository(Evenement::class)->findBy([], ['id' => 'DESC'], 3);    

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact 
             *
             */

            $Contact = $form->getData();
            $Contact->setStatut('reçu');
            $em->persist($Contact);
            $em->flush();


            $this->addFlash('success', 'merci pour votre prise de contact');
            return $this->redirectToRoute('home');
        }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
            'Evenements' => $Evenement,

        ]);
    }
}
