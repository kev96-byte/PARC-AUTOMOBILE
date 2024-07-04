<?php

namespace App\Form;

use App\Entity\Structure;
use App\Entity\Institution;
use App\Entity\TypeStructure;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeStructure', EntityType::class, [
                'required' => true,
                'class' => TypeStructure::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleTypeStructure',
            ])

          ->add('libelleStructure', TextType::class, [
            'empty_data' => '',
            'required' => true,
            'label' => 'Libellé',
            ])

            ->add('telephoneStructure')

            ->add('Institution', EntityType::class, [
                'required' => true,
                'class' => Institution::class,
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                  ->where('n.deleteAt IS NULL');
              },
              'choice_label' => 'libelleInstitution',
          ])
                        
            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
