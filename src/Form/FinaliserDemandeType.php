<?php
// src/Form/FinaliserDemandeType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinaliserDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $kilometragesData = $options['kilometrages_data'];

        $builder
            ->add('dateEffectiveFinMission', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ]);

        foreach ($kilometragesData as $index => $data) {
            $builder
                ->add("kilometrages_{$index}_vehiculeMatricule", TextType::class, [
                    'data' => $data['vehiculeMatricule'],
                    'mapped' => false,
                    'attr' => ['readonly' => true],
                ])
                ->add("kilometrages_{$index}_chauffeurNom", TextType::class, [
                    'data' => $data['chauffeurNom'],
                    'mapped' => false,
                    'attr' => ['readonly' => true],
                ])
                ->add("kilometrages_{$index}_chauffeurPrenom", TextType::class, [
                    'data' => $data['chauffeurPrenom'],
                    'mapped' => false,
                    'attr' => ['readonly' => true],
                ])

                ->add("kilometrages_{$index}_kilometrageCourant", NumberType::class, [
                    'data' => $data['kilometrageCourant'],
                    'mapped' => false,
                    'attr' => ['readonly' => true],
                ])

                ->add("kilometrages_{$index}_kilometrageReleve", NumberType::class, [
                    'data' => $data['kilometrageReleve'],
                    'required' => true,
                ])
/*                 ->add("kilometrages_{$index}_vehiculeId", TextType::class, [
                    'data' => $data['vehiculeId'],
                    'mapped' => false,
                    'attr' => ['readonly' => true],
                ])
                ->add("kilometrages_{$index}_chauffeurId", TextType::class, [
                    'data' => $data['chauffeurId'],
                    'mapped' => false,
                    'attr' => ['readonly' => true],
                ]) */
                ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
        $resolver->setRequired('kilometrages_data');
    }
}
