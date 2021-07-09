<?php

namespace App\Controller;
use App\Entity\Annonce;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;


class SecurityController extends AbstractController
{

  
    /**
     * @Route("/Redirect")
     */
    public function RedirectloginAction(Request $request)
    
    {       
        $session = new Session(new PhpBridgeSessionStorage());

        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');
    
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('pscadmin'));
        }
        elseif (($authChecker->isGranted('ROLE_USER'))) {

            return new RedirectResponse($router->generate('home'));
        }

    }
}
