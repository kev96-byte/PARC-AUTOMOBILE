<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Demande;
use App\Entity\TraiterDemande;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraiterDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('demandeId', EntityType::class, [
                'class' => Demande::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('chauffeurId', EntityType::class, [
                'class' => Chauffeur::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('vehiculeId', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TraiterDemande::class,
        ]);
    }
}
