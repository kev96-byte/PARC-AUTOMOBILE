<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Demande;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numDemande')
            ->add('dateDemande', null, [
                'widget' => 'single_text',
            ])
            ->add('objetMission')
            ->add('dateDebutMission', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFinMission', null, [
                'widget' => 'single_text',
            ])
            ->add('nbreParticipants')
            ->add('nbreVehicules')
            ->add('deleteAt', null, [
                'widget' => 'single_text',
            ])
            ->add('lieu', EntityType::class, [
                'class' => Commune::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('demander', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
            ])
            ->add('validateurStructure', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
            ])
            ->add('traitePar', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
