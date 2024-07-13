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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
                'label' => 'Lieu Mission',
                'choices' => $this->getLieuMissionChoices(),
                'required' => false,
                'multiple' => true,
                'expanded' => false, // ou true si vous voulez des checkboxes
            ])
                      
            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }

     private function getLieuMissionChoices()
    {
        // Exemple de valeurs JSON qui peuvent provenir de la base de données ou d'un autre service
        $json = '[
            {"city": "Paris", "country": "France"},
            {"city": "London", "country": "UK"},
            {"city": "New York", "country": "USA"}
        ]';

        $lieuMissions = json_decode($json, true);
        $choices = [];

        foreach ($lieuMissions as $lieuMission) {
            $label = $lieuMission['city'] . ', ' . $lieuMission['country'];
            $choices[$label] = json_encode($lieuMission);
        }

        return $choices;
    }
}

