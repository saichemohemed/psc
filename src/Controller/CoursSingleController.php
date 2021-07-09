<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\CourSoutien;
use App\Entity\Langue;
use App\Entity\Groupe;


class CoursSingleController extends AbstractController
{
    /**
     * @Route("/cours/single/{id}", name="cours_single")
     */
    public function index(EntityManagerInterface $em,Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $Groupe = $em->getRepository(Groupe::class)->findById($id);    

        $em = $this->getDoctrine()->getManager();
        $Languec = $em->getRepository(Langue::class)->findAll();


        $em = $this->getDoctrine()->getManager();
        $CourSoutien = $em->getRepository(CourSoutien::class)->findAll();    




        return $this->render('cours_single/index.html.twig', [
            'controller_name' => 'CoursSingleController',
            'controller_title' => 'Cours single',
            'Languesc' => $Languec,
            'CourSoutiens' => $CourSoutien,
            'Groupes' => $Groupe,


        ]);
    }
}
