<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Institution;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomChauffeur')
            ->add('prenomChauffeur')
            ->add('telephoneChauffeur')
            ->add('numPermis')
            ->add('etatChauffeur')
            ->add('deleteAt', null, [
                'widget' => 'single_text',
            ])
            ->add('institution', EntityType::class, [
                'class' => Institution::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chauffeur::class,
        ]);
    }
}
