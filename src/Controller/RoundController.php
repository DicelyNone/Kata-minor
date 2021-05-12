<?php

namespace App\Controller;

use App\Repository\FormRepository;
use App\Repository\RoundRepository;
use App\Service\GameService;
use App\Service\RoundService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoundController extends AbstractController
{
    /**
     * @Route("/end-round", name="end-round", methods={"POST"})
     */
    public function endRound(RoundService $roundService, Request $request): Response
    {
        $user = $request->request->get('user');
        $roundId = $request->request->get('roundId');
        $roundService->endRound($roundId);

        return new Response();

    }

    /**
     * @Route("/check-status-end", name="check-status-end", methods={"POST", "GET"})
     */
    public function checkRoundStatus(RoundRepository $roundRepository, Request $request): JsonResponse
    {
        $roundId = $request->request->get('roundId');
        $round = $roundRepository->find($roundId);

        return new JsonResponse([
            'isActive' => $round->getIsActive()
        ]);
    }

    /**
     * @Route("/round-result", name="round-result", methods={"POST", "GET"})
     */
    public function getRoundResult(GameService $gameService, Request $request)
    {
        /*
        $gameId = $request->request->get('gameId');
        $result = $gameService->getResult($gameId);
        return $this->render('game/end.html.twig', [
            'result' => $result
        ]);*/
    }

}
