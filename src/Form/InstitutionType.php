<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\Institution;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleInstitution', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Libellé',
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])

         
            ->add('telephoneInstitution', TelType::class, [
                'empty_data' => '',
            ])

            ->add('adresseMailInstitution', EmailType::class, [
                'empty_data' => '',
                'required' => false,
                'label' => 'Adresse mail',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@gouv\.bj$/',
                        'message' => 'Veuillez entrer une adresse email se terminant par @gouv.bj.',
                    ]),
                ],
            ])

            ->add('adressePostaleInstitution', TextType::class, [
                'empty_data' => '',
                'required' => false,
                'label' => 'Adresse postale',
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])

            ->add('lienSiteWebInstitution', UrlType::class, [
                'required' => false,
                'label' => 'Site Web',
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez entrer une URL valide.',
                    ]),
                ],
            ])

            // Champ non mappé pour afficher le lien de l'ancienne photo
           ->add('logoInstitutionUrl', HiddenType::class, [
            'mapped' => false,
        ])

            ->add('logoInstitution', FileType::class, [
                'label' => 'Télécharger le logo de l\'institution',
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


            ->add('Niveau', EntityType::class, [
                  'class' => Niveau::class,
                  'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                    ->where('n.deleteAt IS NULL');
                },
                'choice_label' => 'libelleNiveau',
                'attr'=>['class'=>'form-control selectpicker',
                    'data-live-search'=>'true',],
            ])
            ->add('save', SubmitType::class, [
                'attr'=>['class'=>'p-component p-button p-button-success',
                    'style'=>'font-weight:bold'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Institution::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
