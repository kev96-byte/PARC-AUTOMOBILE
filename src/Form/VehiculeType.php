<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Vehicule;
use App\Entity\Institution;
use App\Entity\TypeVehicule;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Polyfill\Intl\Idn\Resources\unidata\Regex;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
          
            ->add('TypeVehicule', EntityType::class, [
                'label' => 'Type véhicule',
                'required' => true,
                'class' => TypeVehicule::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleTypeVehicule',
            ])

            ->add('matricule', TextType::class, [
                'label' => 'Matricule du véhicule',
                'label_attr'=>['class' =>'col-sm-12'],     
                'empty_data' => '',
                'required' => true,
            ])

            ->add('numeroChassis', TextType::class, [
                'label' => 'Numéro du chassis',
                'empty_data' => '',
                'required' => false,
            ])

            ->add('marque', EntityType::class, [
                'label' => 'Marque',
                'required' => true,
                'class' => Marque::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleMarque',
            ])

            ->add('modele', TextType::class, [
                'empty_data' => '',
                'label' => 'Modèle',
                'required' => false,
            ])

            ->add('nbrePlace', NumberType::class, [
                'label' => 'Nombre de places',
                'required' => true,
                'attr' => [
                    'min' => 1, // Valeur minimale (peut être ajustée)
                    'max' => 10, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('dateAcquisition', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
            ])
            
            ->add('valeurAcquisition', MoneyType::class, [
                'label' => 'Valeur d\'acquisition (en FCFA)',
                'label_attr'=>['class' =>'col-sm-12'],
                'currency' => 'XOF', // Code de devise pour le Franc CFA (XOF)
                'required' => false,
                // Autres options...
            ])

            ->add('Kilometrage', NumberType::class, [
                'label' => 'Kilométrage du véhicule',
                'label_attr'=>['class' =>'col-sm-12'],
                'scale' => 0, // Pas de décimales
                'constraints' => [
                    new PositiveOrZero([
                        'message' => 'Veuillez entrer un kilométrage positif ou nul.',
                    ]),
                ],
                'required' => true,
            ])


            ->add('Institution', EntityType::class, [
                'required' => true,
                'class' => Institution::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleInstitution',
            ])


            ->add('dateReception', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
            ])


            ->add('dateMiseEnCirculation', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
            ])

            ->add('MiseEnRebut', ChoiceType::class, [
                'label' => 'Mise en rebut',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'placeholder' => 'Non', // Texte par défaut
                'required' => false,
            ])


            ->add('allumage', ChoiceType::class, [
                'label' => 'Type d\'allumage du véhicule',
                'choices' => [
                    'Allumage conventionnel à point de rupture (mécanique)' => 'conventionnel',
                    'Allumage à haute énergie (électronique)' => 'haute_energie',
                    'Allumage sans distributeur (étincelle perdue)' => 'sans_distributeur',
                    'Allumage à bobine' => 'a_bobine',
                    // Ajoutez d'autres options ici...
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => false,
            ])

            ->add('assistanceFreinage', ChoiceType::class, [
                'label' => 'Type d\'assistance au freinage',
                'choices' => [
                    'ABS (Antiblocage des roues)' => 'abs',
                    'AFU (Assistance au Freinage d\'Urgence)' => 'afu',
                    'ESP (Programme électronique de stabilité)' => 'esp',
                    // Ajoutez d'autres options ici...
                ],
                'placeholder' => 'Sélectionnez une option',
                'required' => false,
            ])

            ->add('capaciteCarburant', NumberType::class, [
                'label' => 'Capacité du réservoir (en litres)',
                'required' => false,
                // Autres options de validation si nécessaire
            ])
            
            ->add('categorie', TextType::class, [
                'empty_data' => '',
                'label' => 'Catégorie',
                'required' => false,
            ])

            ->add('cession', ChoiceType::class, [
                'label' => 'Cession',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => false,
            ])

            ->add('chargeUtile', NumberType::class, [
                'label' => 'Charge utile (en kg)',
                'required' => false,
                // Autres options de validation si nécessaire
            ])

            ->add('Climatiseur', ChoiceType::class, [
                'label' => 'Climatisation',
                'choices' => [
                    'Fonctionnelle' => 'Fonctionnelle',
                    'Non fonctionnel' => 'Non fonctionnel',
                    'Absent' => 'Absent',
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => true,
            ])

            ->add('numeroMoteur', NumberType::class, [
                'label' => 'Numéro du moteur',
                'required' => false,
                // Autres options de validation si nécessaire
            ])

            ->add('pma', NumberType::class, [
                'label' => 'Poids Maximum Autorisé (en kg)',
                'required' => false,
                // Autres options de validation si nécessaire
            ])

            ->add('puissance', NumberType::class, [
                'label' => 'Puissance (en chevaux)',
                'required' => true,
                'attr' => [
                    'min' => 1, // Valeur minimale
                    'max' => 1000, // Valeur maximale
                ],
            ])

            ->add('vitesse', NumberType::class, [
                'label' => 'Vitesse (en km/h)',
                'required' => true,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 300, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('cylindree', NumberType::class, [
                'label' => 'Cylindrée (en cm³)',
                'required' => false,
                'attr' => [
                    'min' => 1, // Valeur minimale (peut être ajustée)
                    'max' => 10000, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('directionAssistee', ChoiceType::class, [
                'label' => 'Direction assistée',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => false,
            ])

            ->add('dureeGuarantie', NumberType::class, [
                'label' => 'Durée de garantie (en mois)',
                'required' => false,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 60, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('dureVie', NumberType::class, [
                'label' => 'Durée de vie (en années)',
                'required' => false,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 50, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('freins', ChoiceType::class, [
                'label' => 'Freins',
                'choices' => [
                    'Freins à disque' => 'disque',
                    'Freins à tambour' => 'tambour',
                    'Freins hydrauliques' => 'hydrauliques',
                    // Ajoute d'autres choix si nécessaire
                ],
                'required' => false,
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                // Autres options de validation si nécessaire
            ])

            ->add('pva', NumberType::class, [
                'label' => 'Poids à Vide Autorisé (en kg)',
                'required' => false,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 5000, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('radio', ChoiceType::class, [
                'label' => 'Radio',
                'choices' => [
                    'Fonctionnelle' => 'Fonctionnelle',
                    'Non fonctionnel' => 'Non fonctionnel',
                    'Absent' => 'Absent',
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => true,
            ])

            ->add('typeEnergie', ChoiceType::class, [
                'label' => 'Type d\'énergie',
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Électrique' => 'electrique',
                    // Ajoute d'autres choix si nécessaire
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => true,
                // Autres options de validation si nécessaire
            ])

            ->add('typeTransmission', ChoiceType::class, [
                'label' => 'Type de transmission',
                'choices' => [
                    'Manuelle' => 'manuelle',
                    'Automatique' => 'automatique',
                    // Ajoute d'autres choix si nécessaire
                ],
                'required' => true,
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
            ])

            
            // Champ non mappé pour afficher le lien de l'ancienne photo
            ->add('photoVehiculeUrl', HiddenType::class, [
                'mapped' => false,
            ])

            ->add('photoVehicule', FileType::class, [
                'label' => 'Télécharger la photo du véhicule',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG ou GIF).',
                    ]),
                ],
            ])
                       
            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)
        ;

        
        if ($options['mode'] === 'edit') {
            $builder->add('etat', ChoiceType::class, [
                'choices' => [
                    'En service' => 'En service',
                    'En panne' => 'En panne',
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);

        // Accepter uniquement les valeurs 'add' ou 'edit' pour l'option 'mode'
        $resolver->setAllowedValues('mode', ['add', 'edit']);
    }
}
