<?php

namespace App\Controller;

use App\Repository\IncidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf", name="app_pdf")
     * @param IncidentsRepository $incidentsRepository
     * @return Response
     */
    public function index(IncidentsRepository $incidentsRepository): Response
    {
        // récuperer les dernières informations enregistré en BDD pour les envoyer vers la page PDF
        $content=$incidentsRepository->findBy([],['id'=>'desc'],1,0);

        return $this->render('pdf/index.html.twig', [
            'content' => $content,
        ]);
    }

    /**
     * @Route("/technicien", name="app_technicien")
     * @param IncidentsRepository $repository
     * @return Response
     */
    public function listedFormulary(IncidentsRepository $repository): Response
    {
        return $this->render('pdf/listeFormulaire.html.twig',[
            'liste_formulaire'=>$repository->findAll(),
        ]);
    }
}
