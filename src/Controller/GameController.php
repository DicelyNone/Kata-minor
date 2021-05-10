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
    public function index(GameRepository $gameRepository, GameService $gameService): Response
    {
        // TODO need to post or get param from template
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $game = $gameRepository->getCurrentGame($user, Game::STATUS_PREPARED);

        $form = $gameService->startRound($game);
        $forms[] = $form;

        return $this->render('form/index.html.twig', [
            'forms' => $forms,
        ]);
    }
}
