<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository(Annonce::class)->findAll();
        
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'Annonces' => $Annonce ,
        ]);
    }
}
