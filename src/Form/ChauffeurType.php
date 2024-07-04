<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Institution;
use App\Entity\TypeChauffeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
              'choice_label' => 'libelleInstitution',
          ])

          ->add('matriculeChauffeur', TextType::class, [
            'empty_data' => '',
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


            ->add('telephoneChauffeur')


            ->add('etatChauffeur', ChoiceType::class, [
                'label' => 'Etat Chauffeur',
                'choices' => [
                    'EN SERVICE' => 'EN SERVICE',
                    'EN CONGE' => 'EN CONGE',
                    'EN MISSION' => 'EN MISSION',
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
            'data_class' => Chauffeur::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
