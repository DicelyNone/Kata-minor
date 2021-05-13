<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Queue;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\QueueRepository;
use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class QueueController extends AbstractController
{
    /**
     * @Route("/getIntoQueue", name="getIntoQueue")
     */
    public function create(QueueRepository $queueRepository, Request $request): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!($user instanceof User)) {
            throw new AuthenticationException();
        }

        //$user = $this->getUser();
        $queue = $queueRepository->getActiveQueueRowByUser($user);
        if ($queue){
            $queue->setIsWaiting(false);
        }

        $queueNext = new Queue($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($queueNext);
        $entityManager->flush();

        return $this->render('queue/index.html.twig');
    }

    /**
     * @Route("/check-status", name="check_status", methods={"POST"})
     */
    public function checkStatus(GameRepository $gameRepository): JsonResponse
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $game = $gameRepository->getCurrentGame($user, Game::STATUS_PREPARED);

        if ($game) {
            return new JsonResponse([
                'gameId' => $game->getId(),
                'gameStatus' => $game->getStatus(),
            ]);
        }
        return new JsonResponse();
    }
}
