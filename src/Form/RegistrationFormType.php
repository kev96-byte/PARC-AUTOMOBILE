<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Structure;
use App\Entity\Institution;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
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

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('matricule', TextType::class, [
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


            ->add('email', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Adresse mail',
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
                'expanded' => true,

            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['class' => 'form-control'],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => ['class' => 'form-control'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
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

            ->add('Structure', EntityType::class, [
                'required' => true,
                'class' => Structure::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleStructure',
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
            ])

            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)

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
