<?php

namespace App\Command;

use App\Service\GameService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartGameCommand extends Command
{
    //  php bin/console app:start-game
    protected static $defaultName = 'app:start-game';
    private $gameService;

    public function __construct(GameService $gameService)
    {
        parent::__construct();
        $this->gameService = $gameService;
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
        if ($this->gameService->initGame()) {
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}