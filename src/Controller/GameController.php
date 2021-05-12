<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\RoundRepository;
use App\Service\GameService;
use App\Service\RoundService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/start", name="start")
     */
    public function start(GameRepository $gameRepository, GameService $gameService, Request $request): Response
    {
        //$gameId = $request->request->get('gameId');
        //$game = $gameRepository->find($gameId);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $game = $gameRepository->getCurrentGame($user, Game::STATUS_PREPARED);

        $round = $gameService->startRound($game);

        if ($round) {
            // TODO remove forms[] on front with only one form
            $forms[] = $round->getForm();

            return $this->render('form/index.html.twig', [
                'forms' => $forms,
                'roundId' => $round->getId(),
                'gameId' => $game->getId()
            ]);
        }

        $result = $gameService->getResult($game);
        return $this->render('game/end.html.twig', [
            'rusult' => $result
        ]);
    }
}
