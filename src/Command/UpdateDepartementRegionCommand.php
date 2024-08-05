<?php

namespace App\Command;

use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateDepartementRegionCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('app:update-departement-region')
            ->setDescription('Update region for existing departements');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $departementRepository = $this->entityManager->getRepository(Departement::class);

        $regions = [
            'Nord' => ['Atacora', 'Donga', 'Borgou', 'Alibori'],
            'Centre' => ['Zou', 'Collines'],
            'Sud' => ['Ouémé', 'Plateau', 'Mono', 'Couffo', 'Atlantique', 'Littoral'],
        ];

        foreach ($regions as $region => $departements) {
            foreach ($departements as $libelleDepartement) {
                $departement = $departementRepository->findOneBy(['libelleDepartement' => $libelleDepartement]);
                if ($departement) {
                    $departement->setRegion($region);
                    $this->entityManager->persist($departement);
                }
            }
        }

        $this->entityManager->flush();

        $io->success('Regions have been updated for all departements.');

        return Command::SUCCESS;
    }
}
