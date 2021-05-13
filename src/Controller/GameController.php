<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        if ($game) {
            $round = $gameService->startRound($game);

            if ($round) {
                $forms[] = $round->getForm();

                return $this->render(
                    'form/index.html.twig',
                    [
                        'forms' => $forms,
                        'roundId' => $round->getId(),
                        'gameId' => $game->getId(),
                        'roundOrder' => $round->getOrderInGame()
                    ]
                );
            }
        }

        $finishedGame = $gameService->getLastFinishedGame($user);

        if ($finishedGame) {
            $result = $gameService->getResult($finishedGame);
            $winner = $gameService->getWinner($result);

            return $this->render(
                'game/end.html.twig',
                [
                    'result' => $result,
                    'winner' => $winner,
                ]
            );
        }
    }
}
