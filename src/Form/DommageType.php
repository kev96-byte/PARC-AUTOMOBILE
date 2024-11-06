<?php
namespace App\Form;
use App\Entity\Dommage;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DommageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => 'matricule',
                'label' => 'Véhicule',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->where('v.deleteAt IS NULL')
                        ->andWhere('v.etat = :etat')
                        ->setParameter('etat', 'En service');
                },
                'placeholder' => 'Sélectionnez un véhicule',
            ])
            ->add('chauffeur', EntityType::class, [
                'class' => Chauffeur::class,
                'choice_label' => function (Chauffeur $chauffeur) {
                    return $chauffeur->getNomChauffeur() . ' ' . $chauffeur->getPrenomChauffeur();
                },
                'label' => 'Chauffeur (si présent)',
                'required' => false,
                'placeholder' => 'Aucun conducteur'
            ])
            ->add('typeDommage', ChoiceType::class, [
                'choices' => [
                    'Dommages extérieurs' => [
                        'Rayures' => 'Rayures',
                        'Bosses' => 'Bosses',
                        'Éraflures' => 'Éraflures',
                        'Fissures ou éclats sur les vitres' => 'Fissures ou éclats sur les vitres',
                        'Pare-chocs endommagé' => 'Pare-chocs endommagé',
                        'Phare ou feu arrière cassé' => 'Phare ou feu arrière cassé',
                    ],
                    'Dommages aux pneus et jantes' => [
                        'Pneu crevé' => 'Pneu crevé',
                        'Usure excessive ou irrégulière' => 'Usure excessive ou irrégulière',
                        'Jante tordue ou fissurée' => 'Jante tordue ou fissurée',
                    ],
                    'Dommages mécaniques' => [
                        'Moteur en panne' => 'Moteur en panne',
                        'Transmission défectueuse' => 'Transmission défectueuse',
                        'Problèmes de suspension' => 'Problèmes de suspension',
                        'Problèmes de direction' => 'Problèmes de direction',
                    ],
                    'Dommages intérieurs' => [
                        'Sièges déchirés ou tachés' => 'Sièges déchirés ou tachés',
                        'Tableau de bord endommagé' => 'Tableau de bord endommagé',
                        'Moquette dégradée' => 'Moquette dégradée',
                        'Système de climatisation défectueux' => 'Système de climatisation défectueux',
                    ],
                    'Dommages électriques' => [
                        'Batterie déchargée ou défectueuse' => 'Batterie déchargée ou défectueuse',
                        'Problèmes de câblage' => 'Problèmes de câblage',
                        'Systèmes d\'éclairage interne et externe défectueux' => 'Systèmes d\'éclairage interne et externe défectueux',
                        'Panne des systèmes électroniques (GPS, radio, etc.)' => 'Panne des systèmes électroniques (GPS, radio, etc.)',
                    ],
                    'Dommages dus aux conditions environnementales' => [
                        'Corrosion' => 'Corrosion',
                        'Peinture écaillée' => 'Peinture écaillée',
                        'Dégâts causés par la grêle ou d\'autres intempéries' => 'Dégâts causés par la grêle ou d\'autres intempéries',
                    ],
                ],
                'label' => 'Type de Dommage',
                'placeholder' => 'Sélectionnez un type de dommage',
            ])
            
            ->add('description', TextareaType::class, [
                'label' => 'Description du Dommage',
                'attr' => ['rows' => 5]
            ])
            ->add('dateDommage', DateTimeType::class, [
                'label' => 'Date de l’Incident',
                'widget' => 'single_text',
                'data' => new \DateTime(), // Définit la date actuelle par défaut
            ])
            ->add('save', SubmitType::class, [
                'attr'=>['class'=>'p-component p-button p-button-success',
                    'style'=>'font-weight:bold'],
            ]);

        // Ajouter le champ caché uniquement si on est en mode édition
        if ($options['mode'] === 'edit') {
            $builder->add('vehicule_initial_id', HiddenType::class, [
                'mapped' => false,
                'data' => $options['vehicule_initial_id'], // définir l'ID du véhicule initial
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dommage::class,
            'mode' => 'add', // Par défaut en mode création
            'vehicule_initial_id' => null, // Valeur par défaut de l'ID initial du véhicule
        ]);
    }

}
