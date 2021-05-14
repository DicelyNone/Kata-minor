<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\GameService;
use App\Service\RoundService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/start", name="start")
     */
    public function start(GameRepository $gameRepository, GameService $gameService, RoundService $roundService, Request $request): Response
    {
        //$gameId = $request->request->get('gameId');
        //$game = $gameRepository->find($gameId);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $game = $gameRepository->getCurrentGame($user, Game::STATUS_PREPARED);

        if ($game) {
            $round = $gameService->startRound($game);

            if ($round) {
                $form = $roundService->getFormInRoundByUser($round, $user);

                $forms[] = $form;

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
            $bestScore = $gameService->getBestScoreFromResult($result);

            return $this->render(
                'game/end.html.twig',
                [
                    'result' => $result,
                    'winner' => $winner,
                    'bestScore' => $bestScore,
                ]
            );
        }
    }

    /**
     * @Route("/set-result", name="set-result")
     */
    public function setResult(GameService $gameService, RoundService $roundService, Request $request): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $winner = $request->request->get('winner');
        $result = $request->request->get('result');

        if ($user->getUsername() === $winner){
            $gameService->setWin($user, $result);
        }

        return new Response();
    }
}
