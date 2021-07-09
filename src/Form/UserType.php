<?php
namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints as Assert; 

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('username', TextType::class,['required'=>true])
        ->add('email', EmailType::class)
        ->add('lastName',TextType::class)
        ->add('firstName',TextType::class)
        ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les deux mots de passe ne sont pas identiques.',                
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmation du mot de passe'),
                ))
                ->add('submit', SubmitType::class, ['label'=>'Envoyer', 'attr'=>['class'=>'btn-primary btn-block']])
                


                ->add('phone',TextType::class)
                ->add('gender', ChoiceType::class, [
                    'choices' => ['Femme' => 'Femme', 'Homme' => 'Homme'],
                    'placeholder' => 'Choisir...',
                    'attr' => ['class' => 'form-control',
                    'style'=> 'display: block !important'],
                ])

        ;
    }
}                    
