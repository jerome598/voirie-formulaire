<?php

namespace App\Controller;

use App\Entity\Tplaces;
use App\Form\PlaceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    /**
     * @Route("/home/place", name="place")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $village = new Tplaces();
        $villageForm = $this->createForm(PlaceType::class,$village);
        $villageForm->handleRequest($request);

        if ($villageForm->isSubmitted() && $villageForm->isValid() ) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($village);
            $em->flush();
            return $this->redirectToRoute('validation');
        }


        return $this->render('home/neutrePage.html.twig', [
            'villages'=>$villageForm->createView(),
            'controller_name' => 'PlaceController',
        ]);
    }
}
