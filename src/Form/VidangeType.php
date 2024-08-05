<?php
// src/Form/VidangeType.php
namespace App\Form;

use App\Entity\Vidange;
use App\Entity\Vehicule;
use App\Validator\DatesConstraint;
use App\Repository\VehiculeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class VidangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $defaultDate = $options['is_edit'] ? $builder->getData()->getDateVidange() : new \DateTime();
        // Récupérer le repository des véhicules à partir des options
        $vehiculeRepository = $options['vehicule_repository'];
        $vehicules = $vehiculeRepository->findBy(['deleteAt' => null]);

        $builder
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choices' => $vehicules,
                'choice_label' => function (Vehicule $vehicule) {
                    return $vehicule->getMatricule() . ' (' . $vehicule->getKilometrageCourant() . ' km)';
                },
                'label' => 'Véhicule',
                'attr' => [
                    'class' => 'form-control selectpicker',
                    'data-live-search' => 'true'
                ]
            ])

            ->add('dateVidange', DateType::class, [
                'widget' => 'single_text',
                'data' => $defaultDate,
                'required' => true,
            ])

            // Champ non mappé pour afficher le lien de l'ancienne photo
            ->add('pieceVisiteUrl', HiddenType::class, [
                'mapped' => false,
            ])

            ->add('pieceVidange', FileType::class, [
                'label' => 'Pièce Vidange (PDF)',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'p-component p-button p-button-success',
                    'style' => 'font-weight: bold'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vidange::class,
            'is_edit' => false,
            'mode' => 'add', // Par défaut, en mode création
        ]);

        // Ajouter l'option personnalisée 'vehicule_repository'
        $resolver->setRequired('vehicule_repository');
    }
}
