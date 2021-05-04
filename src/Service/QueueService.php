<?php


namespace App\Service;


use App\Entity\Game;
use App\Repository\QueueRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class QueueService
{
    //private $entityManager;
    private $queueRepository;
    private $gameService;

    public function __construct(/*EntityManagerInterface $entityManager,*/
                                QueueRepository $queueRepository,
                                GameService $gameService)
    {
        //$this->entityManager = $entityManager;
        $this->queueRepository = $queueRepository;
        $this->gameService = $gameService;
    }

    public function createGameForUsersInQueue(): bool
    {
        $waitingUsers = $this->queueRepository->getTwoWaitingUsers();
        if (count($waitingUsers) < Game::USERS_NUM) {
            dump("not enough users for game");
            return false;
        }
        else {
            foreach ($waitingUsers as $userInQueue) {
                $userInQueue->setIsWaiting(false);
                $users[] = $userInQueue->getUser();
            }
            $this->gameService->initGame($users);
        }
        return true;
    }
}