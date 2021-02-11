<?php

namespace App\Controller;

use App\Repository\IncidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    /**
     * @Route("/validation", name="validation")
     * @param IncidentsRepository $incidentsRepository
     * @return Response
     */
    public function index(IncidentsRepository $incidentsRepository): Response
    {
        return $this->render('home/validationFormulaire.html.twig', [
            'controller_name' => 'ValidationController',
            'IncidentValid'=>$incidentsRepository->findAll(),
        ]);
    }
}
