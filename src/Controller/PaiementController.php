<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\Annonce;
use App\Entity\Etudiant;
use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/paiement")
 */
class PaiementController extends AbstractController
{

    /**
     * @Route("/", name="paiement", methods={"GET"})
     */
    public function index(PaiementRepository $paiementRepository,Request $request,EntityManagerInterface $em): Response
    {
       
       
        $Paiement = $em->getRepository(Paiement::class)->findBy(['etudiant' =>$this->getUser()->getid()]);
        
        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository(Annonce::class)->findAll();

        return $this->render('cours/Paiement.html.twig', [
            'paiements' => $paiementRepository->findAll(),
            'paiement' => $Paiement,
            'Annonces' => $Annonce ,

        ]);
    }

    /**
     * @Route("/histoire/", name="histoire")
     */
    public function histoirekAction(Request $request,EntityManagerInterface $em): Response
    {

        $user = $em->getRepository(Paiement::class)->findOneById($request->query->get('id'));
        $Paiement = $em->getRepository(Paiement::class)->findBy(['etudiant' =>$user->getetudiant()->getid()]);


        return $this->render('admin/histoire.html.twig', [
            'paiement' => $request->query->get('id'),
            'paiements' => $Paiement,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paiement $paiement): Response
    {
        
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pscadmin');
        }

        return $this->render('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paiement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paiement $paiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pscadmin');
    }
}
