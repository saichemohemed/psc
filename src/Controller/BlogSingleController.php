<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Evenement;

class BlogSingleController extends AbstractController
{
    /**
     * @Route("/blog/single/{id}", name="blog_single")
     */
    public function index(EntityManagerInterface $em,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->findById($id);    



        return $this->render('blog_single/index.html.twig', [
            'controller_name' => 'BlogSingleController',
            'controller_title' => 'evenement-Single',
            'Evenements' => $evenement,

        ]);
    }
}
