<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Contact;
use FOS\UserBundle\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Form\Contact1Type;


   

class AdminController extends EasyAdminController
{
     /**
     * @Route("/pscadmin/", name="pscadmin")
     */
    public function indexAction(Request $request ) {

        return parent::indexAction($request);
    }

    // public function updateUserEntity($user)
    // {
    //     $this->get('fos_user.user_manager')->updateUser($user, false);
    //     parent::updateEntity($user);
    // }
    // public function createNewUserEntity()
    // {
    //     return $this->get('fos_user.user_manager')->createUser();
    // }

    // public function persistUserEntity($user)
    // {
    //     $this->get('fos_user.user_manager')->updateUser($user, false);
    //     parent::persistEntity($user);
    // }


   

}