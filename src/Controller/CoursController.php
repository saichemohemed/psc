<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Groupe;
use App\Entity\Langue;
use App\Entity\Annonce;
use App\Entity\Contact;
use App\Entity\Message;
use App\Entity\Etudiant;
use App\Form\AnnonceType;
use App\Form\MessageType;
use App\Form\Contact1Type;
use App\Entity\CourSoutien;
use App\Entity\EmploiDuTemps;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class CoursController extends EasyAdminController
{
 
    public function indexAction(Request $request ) {

        return parent::indexAction($request);
     }
        
        
        
    /**
     * @Route("/cours", name="cours")
     */
    public function cours(EntityManagerInterface $em,PaginatorInterface $paginator,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $CourSoutien = $em->getRepository(CourSoutien::class)->findAll();   
        
        
        $em = $this->getDoctrine()->getManager();
        $Groupe = $em->getRepository(Groupe::class)->findAll(); 

        $em = $this->getDoctrine()->getManager();
        $Group = $em->getRepository(Groupe::class)->findAll();    
       
        $Groupe = $paginator->paginate(
            $Groupe,/* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
  

        return $this->render('cours/index.html.twig', [
            'controller_name' => 'Cours',
            'controller_title' => 'Cours ',
            'Groupes' => $Group ,
            'CourSoutiens' => $CourSoutien ,
            'pagination' => $Groupe

        ]);


    }


    /**
     * @Route("/dashboard/cours", name="dashboardcours")
     */
    public function dashboardcours(Request $request)
    {
       
          
        $id=$this->getUser()->getid();

        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository(Annonce::class)->findAll();

        $em = $this->getDoctrine()->getManager();
        $CourSoutien = $em->getRepository(CourSoutien::class)->findAll();    


        $em = $this->getDoctrine()->getManager();
        $Cours = $em->getRepository(Cours::class)->findBy(['etudiant'=>$id]);
  

        $count = count($Cours);


        $em = $this->getDoctrine()->getManager();
        $Groupe = $em->getRepository(Groupe::class)->findAll();

        return $this->render('cours/cours.html.twig', [
            'controller_name' => 'Cours',
            'controller_title' => 'Cours ',
            'count' => $count ,
            'Cours' => $Cours ,
            'Groupes' => $Groupe ,
            'CourSoutiens' => $CourSoutien ,
            'Annonces' => $Annonce ,
            

        ]);

    }


    /**
     * @Route("/dashboard/Emploi", name="dashboardEmploi")
     */
    public function dashboardEmploi(Request $request)
    {
       
          
        $id=$this->getUser()->getid();

        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository(Annonce::class)->findAll();

        $em = $this->getDoctrine()->getManager();
        $Cours = $em->getRepository(Cours::class)->findBy(['etudiant'=>$id]);
        $Groupe = [];
            for ($i=0; $i < count($Cours) ; $i++) { 
                $em = $this->getDoctrine()->getManager();
                $Groupe[] = $em->getRepository(Groupe::class)->findById($Cours[$i]->getgroupe()->getid());

            }


        // $em = $this->getDoctrine()->getManager();
        // $Groupe = $em->getRepository(Groupe::class)->findById($Cours[0]->getgroupe()->getid());


        return $this->render('cours/Emploi.html.twig', [
            'controller_name' => 'Cours',
            'controller_title' => 'Cours ',
            'Cours' => $Cours ,
            'Groupes' => $Groupe ,
            'Annonces' => $Annonce ,


        ]);

    }
    /**
     * @Route("/dashboard/messages", name="dashboardmessages")
     */
    public function dashboardmessages(EntityManagerInterface $em, Request $request):Response
    {
       
        $id = $this->getUser()->getid();
        $Message = $em->getRepository(Message::class)->findBy(['etudiant'=>$id]);

          $session = new Session(new PhpBridgeSessionStorage());
           $session->set('Me', $Message);

        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository(Annonce::class)->findAll();

        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Contact = $form->getData();
            $Contact->setStatut('reçu');
            $Contact->setEtudiant($this->getUser())
            ->setDate(new \DateTime());
            $em->persist($Contact);
            $em->flush();


            return $this->redirectToRoute('dashboardmessages');
        }


        return $this->render('cours/messages.html.twig', [
            'controller_name' => 'Cours',
            'controller_title' => 'Cours ',
            'form' => $form->createView(),
            'Messages' => $Message,
            'Annonces' => $Annonce,
            
        ]);

    }


    /** 
     * @Route("Contact/restock/", name="restock") 
    */

    public function restockAction(Request $request,EntityManagerInterface $em,\Swift_Mailer $mailer)
    {


     $form = $this->createForm(Contact1Type::class);
     $form->handleRequest($request);

     $id = $request->query->get('id');
     $Contacts = $em->getRepository(Contact::class)->findById($id);
     $Pseudo = $Contacts[0]->getPseudo();
     $email = $Contacts[0]->getemail();


     if($form->isSubmitted() && $form->isValid()) {
        /** @var Contact 
         *
        */

         $contact = $form->getData();
         $contact->setStatut('Répondre');


         $message = (new \Swift_Message('Répondre'))
             ->setFrom(['mohamedsaiche.kbm@gmail.com' => 'psc'])
             ->setTo($Contacts[0]->getemail())
             ->setBody('Bonjour ' . $Contacts[0]->getPseudo() .' ' .$contact->getMessage() );
         $mailer->send($message);

         $em->persist($contact);
         $em->flush();

         $this->addFlash('success', 'Le méssage a bien étais envoyer' );

         return $this->redirectToRoute('easyadmin');
     }


        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
            'Pseudo' => $Pseudo,
            'email' => $email
            


        ]);

    }


    /** 
     * @Route("Message", name="Message") 
    */

    public function MessagekAction(Request $request,EntityManagerInterface $em,\Swift_Mailer $mailer)
    { 

     $form = $this->createForm(MessageType::class);
     $form->handleRequest($request);

     $id = $request->query->get('id');
     $Etud = $em->getRepository(Message::class)->findById($id);



     $EtudiantEmail = $Etud[0]->getEtudiant()->getemail();
     $EtudiantId = $Etud[0]->getEtudiant()->getid();
     $EtudiantName = $Etud[0]->getEtudiant()->getlastName() .' '. $Etud[0]->getEtudiant()->getfirstName();



     $em = $this->getDoctrine()->getManager();
     $etudiant = $em->getRepository(Etudiant::class)->findOneById($EtudiantId); 

     if($form->isSubmitted() && $form->isValid()) {
        /** @var Message 
         *
        */
        
         $Mesg = $form->getData();
         $Mesg->setStatut('Répondre')
         ->setEtudiant($Etud[0]->getEtudiant())
         ->setDate(new \DateTime());

         $message = (new \Swift_Message('Répondre'))
             ->setFrom(['mohamedsaiche.kbm@gmail.com' => 'psc'])
             ->setTo($EtudiantEmail)
             ->setBody('Bonjour' .'  '. $EtudiantName .'  '.$Mesg->getContenu() );
         $mailer->send($message);

         $em->persist($Mesg);
         $em->flush();

         $etudiant->setNbm(1);
         $em->persist($etudiant);
         $em->flush();



         $this->addFlash('success', 'Le méssage a bien étais envoyer' );

         return $this->redirectToRoute('easyadmin');
     }
        return $this->render('admin/Message.html.twig', [
            'form' => $form->createView(),   
        ]);

    }

    /** 
     * @Route("/ajax", name="ajax")
    */

    public function ajax(Request $request,EntityManagerInterface $em,\Swift_Mailer $mailer)
    {

        $id = $request->get('id');



        $em = $this->getDoctrine()->getManager();
        $Ann = $em->getRepository(Annonce::class)->findOneBy([], ['id' => 'DESC'], 1);    
        $date = new \DateTime();

        if ($Ann->getDate()->format('d/m/y') <> $date->format('d/m/y')) {
            $Cours = $em->getRepository(Cours::class)->findAll();

            for ($i=0; $i < count($Cours); $i++) {
                $etudiant = $Cours[$i]->getetudiant();
                $email = $Cours[$i]->getetudiant()->getemail();
                $username = $Cours[$i]->getetudiant()->getusername();

                $message = (new \Swift_Message('Rappel'))
                        ->setFrom(['mohamedsaiche.kbm@gmail.com' => 'psc'])
                        ->setTo($email);
                        if ($date->format('d/m/y') == '08/11/20' ) {
                            $message->setBody('Bonjour' .'  '. $username .'  '.'Rappel de paiement des frais de scolarité'  .'  '."la date de paiement et aujourd'hui");}
                        else{$message->setBody('Bonjour' .'  '. $username .'  '.'Rappel de paiement des frais de scolarité'  .'  '.'il reste pour la date de paiement 7 jours');}
                $mailer->send($message);

                $Annonce = new Annonce();
                $Annonce->addEtudiant($etudiant)
                            ->setDate(new \DateTime());
                if ($date->format('d/m/y') == '08/11/20' ) {
                                $Annonce ->setTexteAnnonce("la date de paiement et aujourd'hui");}
                            else{$Annonce ->setTexteAnnonce('il reste pour la date de paiement 7 jours');}
                $Annonce->setTitreAnnonce('Rappel de paiement des frais de scolarité');
                $em->persist($Annonce);
                $em->flush();

                $etudiant->setNb(1);
                $em->persist($etudiant);
                $em->flush();
            }
        }
        $response = new Response(json_encode(array($id)));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /** 
     * @Route("/ajaxnb", name="ajaxnb")
    */

    public function ajaxnb(Request $request)
    {

        $id = $request->get('id');
   
                $em = $this->getDoctrine()->getManager();
                $Etudiant = $em->getRepository(Etudiant::class)->findOneById($id);  
                        $Etudiant->setNb(0);
                                    $em->persist($Etudiant);
                                    $em->flush();
                    
                                
    
        $response = new Response(json_encode(array($id)));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }


 /** 
     * @Route("/ajaxnbm", name="ajaxnbm")
    */

    public function ajaxnbm(Request $request)
    {

        $id = $request->get('id');
   
                $em = $this->getDoctrine()->getManager();
                $Etudiant = $em->getRepository(Etudiant::class)->findOneById($id);  
                        $Etudiant->setNbm(0);
                                    $em->persist($Etudiant);
                                    $em->flush();
                    
                                
    
        $response = new Response(json_encode(array($id)));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }




    /**
    * @Route("/Notification", name="Annonce") 
     */

    public function  AnnonceAction(Request $request)
    {
        // $session = new Session(new PhpBridgeSessionStorage());
           // $session->set('name', $Annonce);

        $em = $this->getDoctrine()->getManager();
        $Annonce = $em->getRepository(Annonce::class)->findAll();

     



        
        return $this->render('cours/Annonce.html.twig', [
            'Annonces'=> $Annonce,
            ]);
    }
        
    

}

