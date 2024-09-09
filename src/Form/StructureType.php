<?php

namespace App\Form;

use App\Entity\Parc;
use App\Entity\User;
use App\Entity\Structure;
use App\Entity\Institution;
use App\Entity\TypeStructure;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StructureType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeStructure', EntityType::class, [
                'required' => true,
                'class' => TypeStructure::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleTypeStructure',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])

          ->add('libelleStructure', TextType::class, [
            'empty_data' => '',
            'required' => true,
            'label' => 'Libellé',
            ])

            ->add('telephoneStructure')

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

          ->add('Parc', EntityType::class, [
            'required' => true,
            'class' => Parc::class,
            'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
              ->where('n.deleteAt IS NULL');
            },
            'choice_label' => 'nomParc',
              'attr'=>[
                  'class'=>'form-control selectpicker', 'data-live-search'=>'true',
              ]
            ])


        ->add('responsableStructure', EntityType::class, [
            'class' => User::class,
            'choices' => $this->userRepository->findResponsableStructure(),
            'choice_label' => function (User $user) {
                return $user->getLastName() . ' ' . $user->getFirstName();
            },
            'placeholder' => 'Sélectionnez le responsable de la structure',
            'attr'=>[
                'class'=>'form-control selectpicker', 'data-live-search'=>'true',
            ]
        ])

        ->add('Parc', EntityType::class, [
            'required' => true,
            'class' => Parc::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('n')
                    ->where('n.deleteAt IS NULL');
            },
            'choice_label' => function ($parc) {
                return $parc->getNomParc() . ' (' . $parc->getInstitution()->getLibelleInstitution() . ')';
            },
            'attr'=>[
                'class'=>'form-control selectpicker', 'data-live-search'=>'true',
            ]
        ])

            ->add('save', SubmitType::class, [
                'attr'=>[
                    'class'=>'p-button p-component p-button-success',
                    'style'=>'font-weight: bold;'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
