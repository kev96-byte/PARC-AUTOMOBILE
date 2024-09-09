<?php
// src/Form/AffecterType.php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Affecter;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AffecterType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $demandeId = $options['demande_id'];
        $demande = $this->entityManager->getRepository(Demande::class)->find($demandeId);

        if (!$demande) {
            throw new \Exception("Demande not found with ID $demandeId");
        }

        $dateFinMission = $demande->getDateFinMission();
        $nbreVehicules = $demande->getNbreVehicules();
        
        // Récupère les véhicules filtrés
        $vehicules = $this->entityManager->getRepository(Vehicule::class)
            ->findAvailableVehicles($dateFinMission);

        // Récupère les chauffeurs filtrés
        $chauffeurs = $this->entityManager->getRepository(Chauffeur::class)
            ->findAvailableChauffeurs();

        $builder
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choices' => $vehicules,
                'choice_label' => function(Vehicule $vehicule) {
                    $calculKmRestant = $vehicule->getNbreKmPourRenouvellerVidange() - 
                        ($vehicule->getKilometrageCourant() - $vehicule->getKilometrageInitial());

                    return sprintf(
                        '%s - %s - %d km',
                        $vehicule->getMatricule(),
                        $vehicule->getPorteeVehicule(),
                        $calculKmRestant
                    );
                },
                'placeholder' => 'Sélectionnez un véhicule',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])
            ->add('chauffeur', EntityType::class, [
                'class' => Chauffeur::class,
                'choices' => $chauffeurs,
                'choice_label' => function(Chauffeur $chauffeur) {
                    return sprintf(
                        '%s - %s %s',
                        $chauffeur->getMatriculeChauffeur(),
                        $chauffeur->getNomChauffeur(),
                        $chauffeur->getPrenomChauffeur()
                    );
                },
                'placeholder' => 'Sélectionnez un chauffeur',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])
            ->add('demande_id', HiddenType::class, [
                'data' => $demandeId,
                'mapped' => false,  // This ensures it's not mapped to the entity
            ])
            ->add('date_fin_mission', HiddenType::class, [
                'data' => $dateFinMission ? $dateFinMission->format('Y-m-d') : null,
                'mapped' => false,  // This ensures it's not mapped to the entity
            ])
            ->add('nbre_vehicules', HiddenType::class, [
                'data' => $nbreVehicules,
                'mapped' => false,  // This ensures it's not mapped to the entity
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affecter::class,
            'numdemande' => null,
        ]);

        // Define the 'demande_id' option without mapping it to the entity
        $resolver->setDefined(['demande_id']);
    }
}
