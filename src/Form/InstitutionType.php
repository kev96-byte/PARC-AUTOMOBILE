<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\Institution;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ])
            
            ->add('telephoneInstitution')

            ->add('Niveau', EntityType::class, [
                  'class' => Niveau::class,
                  'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
                    ->where('n.deleteAt IS NULL');
                },
                'choice_label' => 'libelleNiveau',
            ])
            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)
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
