<?php

namespace App\Controller;

use App\Repository\RoundRepository;
use App\Service\RoundService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse(
            [
                'isActive' => $round->getIsActive(),
                'gameStatus' => $round->getGame()->getStatus(),
                'firstUserForm' => $round->getFirstUserForm()->getArea(),
                'secondUserForm' => $round->getSecondUserForm()->getArea(),
            ]
        );
    }

    /**
     * @Route("/set-form", name="set-form", methods={"POST", "GET"})
     */
    public function setForm(RoundService $roundService, Request $request): Response
    {
        $roundId = $request->request->get('roundId');
        $user = $request->request->get('user');
        $area = $request->request->get('area');

        $roundService->updateFormOfUser($user, $roundId, $area);

        return new Response();
    }
}
