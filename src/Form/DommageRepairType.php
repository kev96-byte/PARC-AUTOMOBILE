<?php
// src/Form/DommageRepairType.php
namespace App\Form;

use App\Entity\Dommage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DommageRepairType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateReparation', DateTimeType::class, [
                'label' => 'Date de Réparation',
                'widget' => 'single_text',
                'required' => true,
                'data' => new \DateTime(), // Définit la date actuelle par défaut
            ])
            ->add('observation', TextareaType::class, [
                'label' => 'Observations',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dommage::class,
        ]);
    }
}
