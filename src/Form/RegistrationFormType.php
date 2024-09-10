<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Structure;
use App\Entity\Institution;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultPassword = 'DefaultPassword123!';
        $builder

            ->add('matricule', IntegerType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Matricule',
            ])



            ->add('lastName', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Nom',
            ])


            ->add('firstName', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Prénom(s)',
            ])


            ->add('username', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Nom d\'utilisateur',
            ])


            ->add('email', EmailType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Adresse mail',
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'adresse email est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@gouv\.bj$/',
                        'message' => 'Veuillez entrer une adresse email se terminant par @gouv.bj.',
                    ]),
                ],
            ])
          
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur simple' => 'ROLE_USER',
                    'Point Focal' => 'ROLE_POINT_FOCAL',
                    'Responsable de Structure' => 'ROLE_RESPONSABLE_STRUCTURE',
                    'Chef Parc' => 'ROLE_CHEF_PARC',
                    'Membre du cabinet' => 'ROLE_CABINET',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'required' => true,
                'multiple' => true,
                'expanded' => false,
                'attr'=>[
                    'class'=>'form-control selectpicker',
                ]

            ]);


if ($options['mode'] === 'add') {
    $builder->add('password', RepeatedType::class, [

        'type' => PasswordType::class,
        'first_options' => [
            'label' => 'Mot de passe',
            'attr' => [
                'class' => 'form-control',
                'value' => $defaultPassword // Valeur par défaut pour le mot de passe
            ],
            'constraints' => [

                new Length([
                    'min' => 8,
                    'minMessage' => 'Le mot de passe doit contenir au moins 8 caractères.',
                    'max' => 4096, // Limite maximale de Symfony pour la longueur du mot de passe
                ]),
                new Regex([
                    'pattern' => '/[A-Z]/',
                    'message' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
                ]),
                new Regex([
                    'pattern' => '/[a-z]/',
                    'message' => 'Le mot de passe doit contenir au moins une lettre minuscule.',
                ]),
                new Regex([
                    'pattern' => '/\d/',
                    'message' => 'Le mot de passe doit contenir au moins un chiffre.',
                ]),
                new Regex([
                    'pattern' => '/[\W]/', // Pour exiger un caractère spécial (non alphanumérique)
                    'message' => 'Le mot de passe doit contenir au moins un caractère spécial (par exemple, @, #, $, etc.).',
                ]),
            ],
        ],
        'second_options' => [
            'label' => 'Confirmer le mot de passe',
            'attr' => [
                'class' => 'form-control',
                'value' => $defaultPassword, // Utilisation de la même variable pour la confirmation
            ],
        ],
        'invalid_message' => 'Les mots de passe ne correspondent pas.',
    ]);
}


            $builder->add('Institution', EntityType::class, [
                'required' => true,
                'class' => Institution::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleInstitution',
                'attr'=>['class'=>'form-control selectpicker',
                    'data-live-search'=>'true',]
            ])

            ->add('telephone', TextType::class, [
                'label' => 'numéro de téléphone',
                'required' => true,
//                'constraints' => [
//                    new Regex([
//                        'pattern' => '/^(\+229)?[0-9]{8}$/',
//                        'message' => 'Veuillez entrer un numéro de téléphone valide au format 61310079 ou +22961310079.',
//                    ]),
//                ],
            ])


            ->add('Structure', EntityType::class, [
                'required' => true,
                'class' => Structure::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleStructure',
                'attr'=>['class'=>'form-control selectpicker',
                    'data-live-search'=>'true',]
            ])
            
            ->add('statutCompte', ChoiceType::class, [
                'label' => 'Statut du compte',
                'choices' => [
                    'Activé' => 'Activé',
                    'Désactivé' => 'Désactivé',
                    'Verrouillé' => 'Verrouillé',
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])

            ->add('save', SubmitType::class,[
                'attr'=>['class'=>'p-component p-button-success p-button',
                    'style'=>'font-weight:bold'],
            ])

            ;
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
