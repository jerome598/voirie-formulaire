<?php

namespace App\Controller;

use App\Repository\IncidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    /**
     * @Route("/_validation", name="app_validation_controller")
     * @param IncidentsRepository $incidentsRepository
     * @return Response
     */
    public function index(IncidentsRepository $incidentsRepository, Request $request): Response
    {
dump($request);
        $num = "0666326508";
        $IPXapikey = "AZERTY";
        //$IPX_host = "10.8.1.102";
        $message = "Votre demande a bien été envoyé.";
        $url = "https://sms.maisdon-sur-sevre.fr/api/xdevices.json?key=" . $IPXapikey . "&SetSMS=" . $num . ":" . $message;

        return $this->render('/home/validationFormulaire.html.twig', [
            'controller_name' => 'ValidationController',
            'IncidentValid'=>$incidentsRepository->findAll(),
            'sms'=>$url,
        ]);
    }
}
