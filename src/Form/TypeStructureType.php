<?php

namespace App\Form;

use App\Entity\TypeStructure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TypeStructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleTypeStructure', TextType::class, [
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
            'data_class' => TypeStructure::class,
        ]);
    }
}
