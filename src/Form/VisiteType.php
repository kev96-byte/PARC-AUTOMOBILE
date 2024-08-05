<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\Visite;

use App\Validator\DatesConstraint;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Définir la date par défaut
        $defaultDateDebut = $options['is_edit'] ? $builder->getData()->getDateDebutVisite() : new \DateTime();

        // Définir la date de fin par défaut
        $defaultDateFin = $options['is_edit'] ? $builder->getData()->getDateFinVisite() : null; 

        $builder
        ->add('vehicule', EntityType::class, [
            'required' => true,
            'class' => Vehicule::class,
            'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
              ->where('n.deleteAt IS NULL');
          },
          'choice_label' => 'matricule',
          'label' => 'Matricule',
            'attr'=>['class'=>'form-control selectpicker', 'data-live-search'=>'true']
        ])

        ->add('dateDebutVisite', DateType::class, [
            'widget' => 'single_text',
            'data' => $defaultDateDebut,
        ])

        ->add('dateFinVisite', DateType::class, [
            'widget' => 'single_text',
            'data' => $defaultDateFin,
        ])

            // Champ non mappé pour afficher le lien de l'ancienne photo
            ->add('pieceVisiteUrl', HiddenType::class, [
                'mapped' => false,
            ])
            
        ->add('pieceVisite', FileType::class, [
            'label' => 'Pièce Visite (PDF)',
            'required' => false,
            'mapped' => false, // This tells Symfony that this field is not directly mapped to a property of the entity
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
            'attr'=>[
                'class'=>'p-component p-button p-button-success',
                'style'=>'font-weight : bold'
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'is_edit' => false,
            'mode' => 'add', // Par défaut, en mode création
            'data_class' => Visite::class,
            'constraints' => [
                new DatesConstraint(),
            ],
        ]);
    }
}
