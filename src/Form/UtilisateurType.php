<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Structure;
use App\Entity\Institution;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UtilisateurType extends AbstractType
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
              'choice_label' => 'libelleInstitution',
          ])

          ->add('Structure', EntityType::class, [
            'required' => true,
            'class' => Structure::class,
            'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
              ->where('n.deleteAt IS NULL');
          },
          'choice_label' => 'libelleStructure',
      ])

          ->add('matriculeUtilisateur', TextType::class, [
            'empty_data' => '',
            'required' => true,
            'label' => 'Matricule',
            ])

          ->add('nomUtilisateur', TextType::class, [
            'empty_data' => '',
            'required' => true,
            'label' => 'Nom utilisateur',
            ])

            ->add('prenomUtilisateur', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Prénom utilisateur',
                ])

            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Sélectionnez une date',
                ],
                'required' => false,
            ])

            ->add('telephoneUtilisateur')

            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => false, // Vous pouvez ajuster selon vos besoins
                // Autres options ici...
            ])

            ->add('login', TextType::class, [
                'label' => 'Login',
                'required' => false, // Vous pouvez ajuster selon vos besoins
                // Autres options ici...
            ])


            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'required' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
                // Autres options ici...
            ])


 /*            ->add('role', EntityType::class, [
                'required' => true,
                'class' => Role::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleRole',
          ])     */     

            
            ->add('etatUtilisateur', ChoiceType::class, [
                'label' => 'Etat du compte',
                'choices' => [
                    'Activé' => 'Activé',
                    'Désactivé' => 'Désactivé',
                ],
                'placeholder' => 'Sélectionnez une option', // Texte par défaut
                'required' => false,
            ])
                        
            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
