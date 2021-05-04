<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\QueueRepository;
use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('main\index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    // TODO remove this function; this is only for dev
    /**
     * @Route("/start", name="start")
     */
    public function start(GameService $gameService, QueueRepository $queueRepository): Response
    {
        $waitingUsers = $queueRepository->getTwoWaitingUsers();
        if (count($waitingUsers) < Game::USERS_NUM) {
            dump("not enough users for game");
        }
        else {
            foreach ($waitingUsers as $userInQueue) {
                $userInQueue->setIsWaiting(false);
                $users[] = $userInQueue->getUser();
            }
            $gameService->initGame($users);
        }
        return $this->render('main\index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
