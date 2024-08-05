<?php

// src/Form/DepartementType.php

namespace App\Form;

use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleDepartement', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Libellé',
            ])
            ->add('region', ChoiceType::class, [
                'choices'  => [
                    'Nord' => 'Nord',
                    'Centre' => 'Centre',
                    'Sud' => 'Sud',
                ],
                'required' => true,
                'label' => 'Région',
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
            'data_class' => Departement::class,
            'mode' => 'add', // Par défaut, en mode création
        ]);
    }
}
