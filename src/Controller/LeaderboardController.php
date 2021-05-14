<?php

namespace App\Controller;

use App\Entity\Leaderboard;
use App\Repository\LeaderboardRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LeaderboardController extends AbstractController
{
    /**
     * @Route("/leaderboard", name="leaderboard")
     */
    public function index(LeaderboardRepository $leaderboardRepository, Request $request): Response
    {
        return $this->render('leaderboard/index.html.twig', [
            'leaderboard' => $leaderboardRepository->findLeaders(10),
        ]);
    }
}
