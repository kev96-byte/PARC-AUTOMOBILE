<?php
// src/Command/TestUserRepositoryCommand.php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;

class TestUserRepositoryCommand extends Command
{
    protected static $defaultName = 'app:test-user-repository';

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Test UserRepository queries')
            ->addArgument('role', InputArgument::REQUIRED, 'Role to search for')
            ->addArgument('institutionId', InputArgument::OPTIONAL, 'Institution ID to search for')
            ->addArgument('structureId', InputArgument::OPTIONAL, 'Structure ID to search for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $role = $input->getArgument('role');
        $institutionId = $input->getArgument('institutionId');
        $structureId = $input->getArgument('structureId');

        // Test findOneByRoleAndInstitution
        if ($institutionId !== null) {
            $user = $this->userRepository->findOneByRoleAndInstitution($role, $institutionId);

            if ($user) {
                $io->success('User found: ' . $user->getLastName() . ' ' . $user->getFirstName());
            } else {
                $io->error('No user found for the given role and institution');
            }
        }

        // Test findOneByRoleAndStructure
        if ($structureId !== null) {
            $user = $this->userRepository->findOneByRoleAndStructure($role, $structureId);

            if ($user) {
                $io->success('User found: ' . $user->getLastName() . ' ' . $user->getFirstName());
            } else {
                $io->error('No user found for the given role and structure');
            }
        }

        return Command::SUCCESS;
    }
}
