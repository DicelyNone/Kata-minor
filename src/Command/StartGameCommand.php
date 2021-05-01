<?php

namespace App\Command;

use App\Service\QueueService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartGameCommand extends Command
{
    //  php bin/console app:start-game
    protected static $defaultName = 'app:start-game';
    private $queueService;

    public function __construct(QueueService $queueService)
    {
        parent::__construct();
        $this->queueService = $queueService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Let the battle begin!')
            ->setHelp('This command will start game for two waiting users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->queueService->createGameForUsersInQueue()) return Command::SUCCESS;
        return Command::FAILURE;
    }
}