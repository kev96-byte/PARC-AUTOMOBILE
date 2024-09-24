<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Institution;
use App\Entity\Parc;
use App\Entity\TypeChauffeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Institution', EntityType::class, [
                'required' => true,
                'class' => Institution::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
                'label' => 'Institution',
              'choice_label' => 'libelleInstitution',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
          ])

            ->add('parc', EntityType::class, [
                'class' => Parc::class,
                'choice_label' => 'nomParc',  // Assurez-vous que 'nom' est un champ dans l'entité Parc que vous voulez afficher
                'placeholder' => 'Sélectionnez un parc',
                'attr'=>[
                    'class'=>'form-control selectpicker', 'data-live-search'=>'true',
                ]
            ])

          ->add('matriculeChauffeur', TextType::class, [
            'required' => true,
            'label' => 'Matricule',
            ])

            ->add('numPermis', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Numéro permis',
                ])

          ->add('nomChauffeur', TextType::class, [
            'empty_data' => '',
            'required' => true,
            'label' => 'Nom chauffeur',
            ])

            ->add('prenomChauffeur', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Prénom chauffeur',
                ])


            ->add('telephoneChauffeur', TelType::class, [
                'empty_data' => '',
                'required' => true,
                'label'=>'Contact chauffeur'
            ])

            // Champ non mappé pour afficher le lien de l'ancienne photo
           ->add('photoChauffeurUrl', HiddenType::class, [
                'mapped' => false,
            ])

            ->add('photoChauffeur', FileType::class, [
                'label' => 'Télécharger la photo du CVA',
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
                        
            ->add('save', SubmitType::class, [
                'attr'=>[
                    'class'=>'p-button p-component p-button-success',
                    'style'=>'font-weight: bold;'
                ]
            ])
        ;


        if ($options['mode'] === 'edit') {
            $builder->add('etatChauffeur', ChoiceType::class, [
                'label' => 'Position du CVA',
                'choices' => [
                    'En service' => 'En service',
                    'En congé' => 'En congé',
                    'En mission' => 'En mission',
                    'A la retraite' => 'A la retraite',
                    'Autorisé à s\'absenter' => 'Autorisé à s\'absenter',
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => false,
            ]);

    }






    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chauffeur::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);

        // Accepter uniquement les valeurs 'add' ou 'edit' pour l'option 'mode'
        $resolver->setAllowedValues('mode', ['add', 'edit']);
    }
}
