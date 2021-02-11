<?php

namespace App\Controller;

use App\Entity\Incidents;
use App\Form\IncidentsType;
use App\Repository\IncidentsRepository;
use App\Repository\TplacesRepository;
use ContainerE6jcxec\getPlaceControllerService;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param TplacesRepository $tplacesRepository
     */
    public function index(Request $request, TplacesRepository $tplacesRepository)
    {
        $incidents = new Incidents();
        $voirieForm = $this->createForm(IncidentsType::class,$incidents);
        $voirieForm->handleRequest($request);

        $incidents->setType(1);
        $incidents->setTechnician(2);
        $incidents->setTGroup(3);
        $incidents->setUse(4);
        $incidents->setDateCreate(new DateTimeImmutable('now'));
        $incidents->setDateModif(new DateTime('now'));
        $incidents->setState(5);
        $incidents->setPriority(6);
        $incidents->setCriticality(7);
        $incidents->setCategory(8);
        $incidents->setTechread(9);
        $incidents->setDisable(10);

        if ( $voirieForm->isSubmitted() && $voirieForm->isValid() ) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($incidents);
            $em->flush();

 dump($incidents);
            $num = $incidents->getTel();
            /*$IPXapikey = "AZERTY";
            $IPX_host = "10.8.1.102";
            $message = "Votre demande à bien était envoyée auprès de nos services de la mairie de Maisdon-sur-Sèvre. Bonne journée.";
            if (strlen($num) == 10 && ctype_digit($num) && (substr($num, 0, 2) == '06' || substr($num, 0, 2) == '07')) {
                $ch = curl_init();
                $url = "http://" . $IPX_host . "/api/xdevices.json?key=" . $IPXapikey . "&SetSMS=" . $num . ":" . $message;
                //echo $url.'<br>';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_exec($ch);
                curl_close($ch);
            }*/
            return $this->redirectToRoute('validation', []
            //return $this->redirect('https://sms.mms.fr/api/xdevices.json?key=AZERTY&SetSMS='.$num.':test'
            );
            }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'voirie' => $voirieForm->createView(),
            'villages'=>$tplacesRepository->findAll(),

        ]);
        }

  /*  public function send(int $num): void
    {
        $IPXapikey = "AZERTY";
        $IPX_host = "10.8.1.102";
        $message = "Votre demande à bien était envoyée auprès de nos services de la mairie de Maisdon-sur-Sèvre. Bonne journée.";
        if (strlen($num) == 10 && ctype_digit($num) && (substr($num, 0, 2) == '06' || substr($num, 0, 2) == '07')) {
            $ch = curl_init();
            $url = "http://" . $IPX_host . "/api/xdevices.json?key=" . $IPXapikey . "&SetSMS=" . $num . ":" . $message;
//echo $url.'<br>';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_exec($ch);
            curl_close($ch);
//echo '<br>'.$num.'##'.$message.'##'.$url.'<br>';
        }
    }*/


/*
    public function checkPage(): Response
    {
        return $this->render('home/validationFormulaire.html.twig');
    }
*/
 //   /**
//     * @Route("/addvillages", name="app_addvillages")
 //    */
 /*   public function add(EntityManagerInterface $entityManager, TplacesRepository $tplacesRepository): Response
    {
            for($i = 0 ; $i < 30 ; $i++) {
                $villages = new Tplaces();
                $villages->setName("Villages_{$i}_{$i}");
                $entityManager->persist($villages);
            }
                $entityManager->flush();
        return $this->render('home/neutrePage.html.twig',[
            'controller_name' => 'Ajout Ok',
            'tvillages' =>$tplacesRepository->findAll(),
        ]);
    }
*/
}

