<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\Assurance;

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

class AssuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('vehiculeId', EntityType::class, [
            'required' => true,
            'class' => Vehicule::class,
            'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
              ->where('n.deleteAt IS NULL');
          },
          'choice_label' => 'matricule',
          'label' => 'Matricule',
            'attr'=>['class'=>'form-control selectpicker', 'data-live-search'=>'true']
        ])


        ->add('dateDebutAssurance', DateType::class, [
            'widget' => 'single_text',
            'data' => new \DateTime(), // Définir la date par défaut à aujourd'hui
        ])
        ->add('dateFinAssurance', DateType::class, [
            'widget' => 'single_text',
        ])

            // Champ non mappé pour afficher le lien de l'ancienne photo
            ->add('pieceAssuranceUrl', HiddenType::class, [
                'mapped' => false,
            ])
            
        ->add('pieceAssurance', FileType::class, [
            'label' => 'Pièce Assurance (PDF)',
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
            'attr'=>['class'=>'p-component p-button p-button-success', 'style'=>'font-weight: bold']
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mode' => 'add', // Par défaut, en mode création
            'data_class' => Assurance::class,
            'constraints' => [
                new DatesConstraint(),
            ],
        ]);
    }
}
