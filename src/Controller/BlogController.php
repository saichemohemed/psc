<?php

namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(EntityManagerInterface $em,PaginatorInterface $paginator,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository(Evenement::class)->findAll();    

        $Evenement = $paginator->paginate(
            $Evenement,/* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'controller_title' => 'evenement',
            'Evenements' => $Evenement,
            'pagination' => $Evenement

        ]);
    }
}
