<?php

namespace App\Form;

use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleNiveau', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Libellé',
            ])

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'p-component p-button p-button-success',
                    'style' => 'font-weight:bold;',],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Niveau::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
