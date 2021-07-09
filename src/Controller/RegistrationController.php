<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\UserType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class RegistrationController extends BaseController
{

  
    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory     = $formFactory;
        $this->userManager     = $userManager;
        $this->tokenStorage    = $tokenStorage;
    }
    
    /**
     * @Route("/register/ee")
     */
    
    public function registerAdminAction(Request $request) {

        // 1) build the form
        $user = new Admin();
        $form = $this->createForm(UserType::class, $user);
        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form->setData($user);       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
           
            //on active par défaut
            $user->setEnabled(true);
            $user->setRoles(['ROLE_ADMIN']);   
            $user->setImageName('admin.jpg');
            $user->setImagePath('asset/img/myimg/');
            $user->setUpdatedAt(new \DateTime()); 
            $user->setDatecreated(new \DateTime()); 
            
            // 4) save the User!
            $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                  }

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
        
        }
        return $this->render('registerAdmin/registerAdmin.html.twig', [ 
            'form' => $form->createView(), 'mainNavRegistration' => true,
            'title' => 'Inscription']);
    }
}


