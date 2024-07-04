<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Departement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CommuneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('Departement', EntityType::class, [
            'class' => Departement::class,
            'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('n')
              ->where('n.deleteAt IS NULL');
          },
          'choice_label' => 'libelleDepartement',
        ])

            ->add('libelleCommune', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Libellé',
            ])

            ->add('save', SubmitType::class)

            ->add('cancel', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commune::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
