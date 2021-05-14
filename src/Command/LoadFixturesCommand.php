<?php

namespace App\Command;

use App\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesCommand extends Command
{
    protected static $defaultName = 'app:install';

    private $fixtures;

    private $entityManager;

    public function __construct(AppFixtures $fixtures, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->fixtures = $fixtures;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->fixtures->load($this->entityManager);

        return Command::SUCCESS;
    }
}