<?php

namespace App\Controller;

use App\Entity\Tincidents;
use App\Form\IncidentsType;
use App\Entity\Tplaces;
use App\Form\PlaceType;
use App\Repository\IncidentsRepository;
use App\Repository\TplacesRepository;
use ContainerE6jcxec\getPlaceControllerService;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param TplacesRepository $tplacesRepository
     * @return RedirectResponse|Response
     */
    public function index(Request $request, TplacesRepository $tplacesRepository)
    {
        $incidents = new Tincidents();
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
            $file = $incidents->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$fileName);
            $incidents->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($incidents);
            $em->flush();
            $num = $incidents->getTel();
            $mail=$incidents->getEmail();
            $titre=$incidents->getTitle();
            $demande=$incidents->getDescription();
            $date=$incidents->getDateCreate();
            $reponseValid = [$num,$mail,$demande,$titre,$date];


            return $this->redirectToRoute('app_validation', [
                    'sms'=>$num,
                    'reponse'=>$reponseValid,
                ]);
            }


        return $this->render('home/index.html.twig', [
            'voirie' => $voirieForm->createView(),
            'villages'=>$tplacesRepository->findAll(),

        ]);
        }

    /**
     * @Route ("/validation", name="app_validation")
     * @param Request $request
     * @return Response
     */
        public function validation(Request $request): Response
        {
            $num = $request->get('sms');
            $titre = $request->get('reponse',4);
            $description= $request->get('reponse',3);
            $date = $request->get('reponse',5);
            $IPXapikey = "AZERTY";

            $message = "Titre: description: Date: ";

            if (substr($num, 0, 2) == '06' || substr($num, 0, 2) == '07') {
                $url = "https://sms.maisdon-sur-sevre.fr/api/xdevices.json?key=" . $IPXapikey . "&SetSMS=" . $num . ":" .$message."";

                return $this->render('home/validation.html.twig', [
                    'sms' => $url,
                    'ok'=> 'true',
                ]);
            }
            return $this->render('home/validation.html.twig', [
                'sms' => 'valider',
                'ok'=> 'false',]
            );
        }



/*
    public function checkPage(): Response
    {
        return $this->render('home/validationFormulaire.html.twig');
    }
*/
 //   /**
//     * @Route("/addvillages", name="app_addvillages")
//     * @param EntityManagerInterface $entityManager
//     * @param TplacesRepository $tplacesRepository
//     * @return Response
//     */
/*    public function add(EntityManagerInterface $entityManager, TplacesRepository $tplacesRepository): Response
    {
            for($i = 0 ; $i < 30 ; $i++) {
                $villages = new Tplaces();
                $villages->setName("Villages_{$i}_{$i}");
                $entityManager->persist($villages);
            }
                $entityManager->flush();
        return $this->render('place/index.html.twig',[
            'controller_name' => 'Ajout Ok',
            'tvillages' =>$tplacesRepository->findAll(),
        ]);
    }
*/
}

