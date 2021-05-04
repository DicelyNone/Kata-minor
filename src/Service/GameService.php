<?php


namespace App\Service;


use App\Entity\Game;
use App\Repository\QueueRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function initGame(array $waitingUsers)
    {
        $game = new Game($waitingUsers);
        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }
}