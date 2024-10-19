<?php

namespace App\Form;

use App\Entity\Parc;
use App\Entity\User;
use App\Entity\Institution;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParcType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder        
            ->add('nomParc', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Libellé',
            ])

            ->add('telephoneParc', TelType::class, [
                'empty_data' => '',
                'required' => true,
                'label'=>'Contact chauffeur'
            ])

            ->add('emailParc', EmailType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Adresse mail',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@gouv\.bj$/',
                        'message' => 'Veuillez entrer une adresse email se terminant par @gouv.bj.',
                    ]),
                ],
            ])

           
            ->add('Institution', EntityType::class, [
                'required' => true,
                'class' => Institution::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleInstitution',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])
            

            ->add('chefParc', EntityType::class, [
                'class' => User::class,
                'label'=>'Chef parc',
                'choices' => $this->userRepository->findChefsParc(),
                'choice_label' => function (User $user) {
                    return $user->getLastName() . ' ' . $user->getFirstName();
                },
                'placeholder' => 'Sélectionnez le responsable du parc',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])


            ->add('validateurParc', EntityType::class, [
                'class' => User::class,
                'label'=>'Validateur du parc',
                'choices' => $this->userRepository->findValidateurParc(),
                'choice_label' => function (User $user) {
                    return $user->getLastName() . ' ' . $user->getFirstName();
                },
                'placeholder' => 'Sélectionnez le responsable du parc',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])

            
            ->add('save', SubmitType::class, [
                'attr'=>['class'=>'p-component p-button p-button-success',
                    'style'=>'font-weight:bold'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parc::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
