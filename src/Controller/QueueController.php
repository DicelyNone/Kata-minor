<?php

namespace App\Controller;

use App\Entity\Queue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QueueController extends AbstractController
{
    /**
     * @Route("/getIntoQueue", name="getIntoQueue")
     */
    public function create(Request $request): Response
    {
        $queueNext = new Queue($this->get('security.token_storage')->getToken()->getUser());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($queueNext);
        $entityManager->flush();

        return $this->render('queue/index.html.twig');
    }
}
