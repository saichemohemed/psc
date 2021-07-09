<?php
 
namespace App\Form;
 
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use UserBundle\Repository\GenderRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;


class RegistrationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName',TextType::class)
            ->add('firstName',TextType::class)
            ->add('birthPlace',TextType::class,['required'=>false])
            ->add('birthdate', BirthdayType::class, [               
                'widget' => 'single_text', 
                'required'=>false          
            ])
            ->add('address',     TextType::class,['required'=>false])
           ->add('phone',     TextType::class)
           ->add('gender', ChoiceType::class, [
            'attr' => ['class' => 'browser-default custom-select'],
            'choices' => ['RegistrationType.gender.choices.Women' => 'Femme', 'RegistrationType.gender.choices.Man' => 'Homme'],
            'placeholder' => 'RegistrationType.gender.placeholder',
        ])
        ->add('nom_pere')
        ->add('nom_mere')
        ->add('num_tel_pere')
        ->add('num_tel_mere')
        ->add('profession_pere')
        ->add('profession_mere')
        
        ;
    }
     
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}