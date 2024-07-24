<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\CommuneRepository;

class DemandeType extends AbstractType
{
    private $communeRepository;

    public function __construct(CommuneRepository $communeRepository)
    {
        $this->communeRepository = $communeRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $communeChoices = $this->communeRepository->findActiveCommunesFormatted();
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
                'choices' => $communeChoices,
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control selectpicker',
                    'data-live-search' => true,
                ],
            ])

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

