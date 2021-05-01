<?php


namespace App\Service;


use App\Entity\Game;
use App\Repository\QueueRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    private $entityManager;
    private $gameRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                QueueRepository $gameRepository)
    {
        $this->entityManager = $entityManager;
        $this->gameRepository = $gameRepository;
    }

    // not User[] because of anonymous users
    public function initGame(array $waitingUsers)
    {
        $game = new Game($waitingUsers);
        dump("game created");
    }
}