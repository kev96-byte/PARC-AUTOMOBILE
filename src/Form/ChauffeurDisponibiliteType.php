<?php
// src/Form/ChauffeurDisponibiliteType.php

namespace App\Form;

use App\Entity\Parc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ChauffeurDisponibiliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parc', EntityType::class, [
                'class' => Parc::class,
                'choice_label' => 'nomParc',
                'placeholder' => 'Sélectionnez un parc',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])
            ->add('dateDebutMission', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'data' => new \DateTime(), // Définit la date actuelle par défaut
            ])
            ->add('dateFinMission', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'data' => new \DateTime(), // Définit la date actuelle par défaut
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
