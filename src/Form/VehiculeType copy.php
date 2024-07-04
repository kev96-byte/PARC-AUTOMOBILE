<?php

namespace App\Form;

use App\Entity\Financement;
use App\Entity\TypeVehicule;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('numeroChassis')
            ->add('marque')
            ->add('modele')
            ->add('nbrePlace')
            ->add('etat')
            ->add('dateAcquisition', null, [
                'widget' => 'single_text',
            ])
            ->add('valeurAcquisition')
            ->add('Kilometrage')
            ->add('dateReception', null, [
                'widget' => 'single_text',
            ])
            ->add('dateMiseEnCirculation', null, [
                'widget' => 'single_text',
            ])
            ->add('MiseEnRebut')
            ->add('dateDebutVisiteTechnique', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFinVisiteTechnique', null, [
                'widget' => 'single_text',
            ])
            ->add('dateEntretien', null, [
                'widget' => 'single_text',
            ])
            ->add('alimentation')
            ->add('allumage')
            ->add('assistanceFreinage')
            ->add('capaciteCarburant')
            ->add('categorie')
            ->add('cession')
            ->add('chargeUtile')
            ->add('climatiseur')
            ->add('nbreCylindre')
            ->add('numeroMoteur')
            ->add('PMA')
            ->add('puissance')
            ->add('vitesse')
            ->add('cylindree')
            ->add('directionAssistee')
            ->add('dureeGuarantie')
            ->add('dureVie')
            ->add('energie')
            ->add('freins')
            ->add('PVA')
            ->add('radio')
            ->add('typeEnergie')
            ->add('typeTransmission')
            ->add('disponibilite')
            ->add('financement', EntityType::class, [
                'class' => Financement::class,
                'choice_label' => 'id',
            ])
            ->add('typeVehicule', EntityType::class, [
                'class' => TypeVehicule::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
