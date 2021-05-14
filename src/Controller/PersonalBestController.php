<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PersonalBestController extends AbstractController
{
    /**
     * @Route("/personal-best", name="personal-best")
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user)
        {
            throw new NotFoundHttpException("User $user not found");
        }
        return $this->render('personalBest/index.html.twig', [
            'personalBest' => $user->getPersonalBest(),
        ]);
    }
}
