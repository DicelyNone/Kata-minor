<?php

namespace App\Controller;

use App\Repository\FormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(FormRepository $formRepository): Response
    {
        $forms = $formRepository->findAll();
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'forms' => $forms,
        ]);
    }
}
