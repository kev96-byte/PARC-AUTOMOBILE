<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Demande;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandeType extends AbstractType
{
    private $entityManager;
    private $security;    

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $communeChoices = $this->entityManager->getRepository(Commune::class)->findActiveCommunesFormatted();
        // Vérifier si l'utilisateur connecté a le rôle ROLE_POINT_FOCAL_AVANCE
        if ($this->security->isGranted('ROLE_POINT_FOCAL_AVANCE')) {
            $vehiculeChoices = $this->entityManager->getRepository(Vehicule::class)->findActiveVehiculesFormatted();
            $chauffeurChoices = $this->entityManager->getRepository(Chauffeur::class)->findActiveChauffeursFormatted();         
        }

        $builder
            ->add('dateDebutMission', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Sélectionnez une date',
                    'class' => 'js-datepicker',
                ],
                'required' => false,
            ])



            ->add('dateFinMission', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Sélectionnez une date',
                ],
                'required' => false,
            ])

            ->add('objetMission', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Objet de la mission',
            ])

            ->add('referenceNoteDeService', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Référence de la note de service',
            ])

            ->add('nbreParticipants', NumberType::class, [
                'label' => 'Nombre de participants',
                'required' => true,
                'attr' => [
                    'min' => 1, // Valeur minimale (peut être ajustée)
                    'max' => 10, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('nbreVehicules', NumberType::class, [
                'label' => 'Nombre de véhicules',
                'required' => true,
                'attr' => [
                    'min' => 1, // Valeur minimale (peut être ajustée)
                    'max' => 10, // Valeur maximale (peut être ajustée)
                ],

            ])
            

            ->add('lieuMission', ChoiceType::class, [
                'label' => 'Lieux de Mission',
                'required' => true,
                'choices' => $communeChoices,
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control selectpicker',
                    'data-live-search' => true,
                ],
            ]);


            if ($this->security->isGranted('ROLE_POINT_FOCAL_AVANCE')) {
                $builder
                    ->add('vehicules', ChoiceType::class, [
                        'label' => 'Véhicules',
                        'required' => false,
                        'choices' => $vehiculeChoices,
                        'multiple' => true,
                        'expanded' => false,
                        'attr' => [
                            'class' => 'form-control selectpicker',
                            'data-live-search' => true,
                        ],
                    ])

                    ->add('chauffeurs', ChoiceType::class, [
                        'label' => 'Chauffeurs',
                        'required' => false,
                        'choices' => $chauffeurChoices,
                        'multiple' => true,
                        'expanded' => false,
                        'attr' => [
                            'class' => 'form-control selectpicker',
                            'data-live-search' => true,
                        ],
                    ]);
            }

            $builder
                ->add('save', SubmitType::class, [
                    'attr'=>['class'=>'p-component p-button p-button-success','style'=>'font-weight: bold;']

                ])
            ;


        }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }

}

 