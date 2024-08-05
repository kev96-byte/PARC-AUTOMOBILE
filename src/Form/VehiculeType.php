<?php

namespace App\Form;

use App\Entity\Parc;
use App\Entity\Marque;
use App\Entity\Vehicule;
use App\Entity\Institution;
use App\Entity\TypeVehicule;
use App\Entity\TypeStructure;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Polyfill\Intl\Idn\Resources\unidata\Regex;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Sélectionnez le type de véhicule'
                ]
            ])


            ->add('porteeVehicule', ChoiceType::class, [
                'choices'  => [
                    'Nord' => 'Nord',
                    'Centre' => 'Centre',
                    'Sud' => 'Sud',
                ],
                'required' => true,
                'label' => 'Porté du véhicule',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Sélectionnez la portée du véhicule'
                ]
            ])

            ->add('matricule', TextType::class, [
                'label' => 'Matricule du véhicule',
                'empty_data' => '',
                'required' => true,
                'attr'=>['placeholder'=>'Entrer le matricule du véhicule'],
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le matricule doit être supérieur à zéro.'
                    ]),
                    new NotEqualTo([
                        'value' => 0,
                        'message' => 'Le matricule ne peut pas être égal à zéro.'
                    ]),
                ],
            ])

            ->add('Parc', EntityType::class, [
                'required' => true,
                'class' => Parc::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
                },
                'choice_label' => 'nomParc',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Sélectionnez le parc'
                ]
                ])

            ->add('numeroChassis', TextType::class, [
                'label' => 'Numéro du chassis',
                'attr'=>['placeholder'=>'Entrer le numéro de chassis'],
                'empty_data' => '',
                'required' => true,
            ])

            ->add('marque', EntityType::class, [
                'label' => 'Marque',
                'required' => true,
                'class' => Marque::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleMarque',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Sélectionnez la marque du véhicule'
                ]
            ])

            ->add('modele', TextType::class, [
                'empty_data' => '',
                'label' => 'Modèle',
                'required' => false,
                'attr'=>['placeholder'=>'Entrer le modèle du véhicule'],
            ])

            ->add('nbrePlace', IntegerType::class, [
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
                'attr'=>['placeholder'=>'Entrer le modèle du véhicule'],
            ])
            
            ->add('valeurAcquisition', MoneyType::class, [
                'label' => 'Valeur d\'acquisition (en FCFA)',
                'currency' => 'XOF', // Code de devise pour le Franc CFA (XOF)
                'required' => false,
                'attr'=>['placeholder'=>'Entrer le modèle du véhicule'],
                // Autres options...
            ])

            ->add('kilometrageInitial', IntegerType::class, [
                'label' => 'Kilométrage Initial',
                'constraints' => [
                    new PositiveOrZero([
                        'message' => 'Veuillez entrer un kilométrage positif ou nul.',
                    ]),
                ],
                'required' => true,
            ])

            ->add('kilometrageCourant', IntegerType::class, [
                'label' => 'Kilométrage Couant',
                'constraints' => [
                    new PositiveOrZero([
                        'message' => 'Veuillez entrer un kilométrage positif ou nul.',
                    ]),
                ],
                'required' => true,
            ])

            ->add('nbreKmPourRenouvellerVidange', IntegerType::class, [
                'label' => 'Nombre de Km à parcourrir avant de renouveller la vidange',
                'constraints' => [
                    new PositiveOrZero([
                        'message' => 'Veuillez entrer une valeur positif ou nul.',
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
                'attr'=>[
                    'placeholder'=>'Choisissez l\'institution',
                    'class'=>'form-control',
                    ]
            ])


            ->add('dateReception', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Sélectionnez une date',
                ]
            ])


            ->add('dateMiseEnCirculation', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Sélectionnez une date',
                ]
            ])

            ->add('MiseEnRebut', ChoiceType::class, [
                'label' => 'Mise en rebut',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'placeholder'=>'Choisisez une option',
                'attr'=>[

                    'class'=>'form-control'
                ],
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
                'placeholder' => 'Choisissez une option', // Texte par défaut
                'required' => false,
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])

            ->add('assistanceFreinage', ChoiceType::class, [
                'label' => 'Type d\'assistance au freinage',
                'choices' => [
                    'ABS (Antiblocage des roues)' => 'abs',
                    'AFU (Assistance au Freinage d\'Urgence)' => 'afu',
                    'ESP (Programme électronique de stabilité)' => 'esp',
                    // Ajoutez d'autres options ici...
                ],
                'attr'=>[
                    'class'=>'form-control',
                ],
                'placeholder'=>'Choisissez une option',
                'required' => false,
            ])

            ->add('capaciteCarburant', IntegerType::class, [
                'label' => 'Capacité du réservoir (en litres)',
                'required' => false,
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'La valeur doit être supérieure à zéro.',
                    ]),
                ],
                // Autres options de validation si nécessaire
            ])
            
            ->add('categorie', TextType::class, [
                'empty_data' => '',
                'label' => 'Catégorie',
                'required' => false,
                'attr'=>[
                    'placeholder'=>'Entrez la catégorie',
                ]

            ])

            ->add('cession', ChoiceType::class, [
                'label' => 'Cession',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Sélectionnez une option',
                ],
                'required' => false,
            ])

            ->add('chargeUtile', IntegerType::class, [
                'label' => 'Charge utile (kg)',
                'required' => false,
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'La charge utile doit être supérieure à zéro.',
                    ]),
                ],
                
            ])

            ->add('Climatiseur', ChoiceType::class, [
                'label' => 'Climatisation',
                'choices' => [
                    'Fonctionnelle' => 'Fonctionnelle',
                    'Non fonctionnel' => 'Non fonctionnel',
                    'Absent' => 'Absent',
                ],
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Choisissez une option',
                ],
                'required' => true,
            ])

            ->add('numeroMoteur', TextType::class, [
                'label' => 'Numéro du moteur',
            ])

            ->add('pma', IntegerType::class, [
                'label' => 'Poids Maximum Autorisé (kg)',
                'required' => false,
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'La valeur du poids doit être supérieure à zéro.',
                    ]),
                ],
            ])

            ->add('puissance', IntegerType::class, [
                'label' => 'Puissance (en chevaux)',
                'required' => true,
                'attr' => [
                    'min' => 1, // Valeur minimale
                    'max' => 1000, // Valeur maximale
                ],
            ])

            ->add('vitesse', IntegerType::class, [
                'label' => 'Vitesse (en km/h)',
                'required' => true,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 300, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('cylindree', IntegerType::class, [
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
                'placeholder' => 'Sélectionnez une option',
                'attr'=>[

                    'class'=>'form-control',
                ],
                'required' => false,
            ])

            ->add('dureeGuarantie', IntegerType::class, [
                'label' => 'Durée de garantie (en mois)',
                'required' => false,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 60, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('dureVie', IntegerType::class, [
                'label' => 'Durée de vie (en années)',
                'required' => false,
                'attr' => [
                    'min' => 0, // Valeur minimale (peut être ajustée)
                    'max' => 50, // Valeur maximale (peut être ajustée)
                ],
            ])

            ->add('freins', ChoiceType::class, [
                'label' => 'Freins',
                'placeholder' => 'Sélectionnez une option',
                'choices' => [
                    'Freins à disque' => 'disque',
                    'Freins à tambour' => 'tambour',
                    'Freins hydrauliques' => 'hydrauliques',
                    // Ajoute d'autres choix si nécessaire
                ],
                'required' => false,
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])

            ->add('pva', IntegerType::class, [
                'label' => 'Poids à Vide Autorisé (kg)',
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
                'placeholder' => 'Choisissez une option', // Texte par défaut
                'required' => true,
                'attr'=>['class'=>'form-control'],
            ])

            ->add('typeEnergie', ChoiceType::class, [
                'label' => 'Type d\'énergie',
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Électrique' => 'electrique',
                    // Ajoute d'autres choix si nécessaire
                ],
                'placeholder' => 'Choisissez une option', // Texte par défaut
                'required' => true,
                'attr'=>['class'=>'form-control'],
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
                'placeholder' => 'Choisissez une option', // Texte par défaut
                'attr'=>['class'=>'form-control']
            ])

            
            // Champ non mappé pour afficher le lien de l'ancienne photo
            ->add('photoVehiculeUrl', HiddenType::class, [
                'mapped' => false,
            ])

            ->add('photoVehicule', FileType::class, [
                'label' => 'Télécharger la photo du véhicule',
                'mapped' => false,
                'attr'=>['class'=>'form-control'],
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

            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En service' => 'En service',
                    'En panne' => 'En panne',
                ],
                'attr'=>['class'=>'form-control'],
            ])
                       
            ->add('save', SubmitType::class, [
                'attr'=>[ 'class'=>'p-component p-button p-button-success',
                            'style'=>'font-weight: bold'
                ],
            ])
        ;
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
