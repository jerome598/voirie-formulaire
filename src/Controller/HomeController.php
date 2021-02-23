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
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Cast\Array_;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
    public function index(Request $request, TplacesRepository $tplacesRepository, IncidentsRepository $incidentsRepository)
    {
        $incidents = new Tincidents();
        $voirieForm = $this->createForm(IncidentsType::class,$incidents);
        $voirieForm->handleRequest($request);

        $incidents->setType(1);
        $incidents->setTechnician(7);
        $incidents->setTGroup(0);
        $incidents->setUse(9);
        $incidents->setDateCreate(new DateTimeImmutable('now'));
        //$incidents->setDateModif(new DateTime('now'));
        $incidents->setState(1);
        $incidents->setPriority(3);
        $incidents->setCriticality(2);
        $incidents->setCategory(3);
        $incidents->setTechread(0);
        $incidents->setDisable(0);

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
            $date= $incidents->getDateCreate()->format('d-m-y');

            $reponseValid = [$num,$mail,$demande,$titre,$date];


            return $this->redirectToRoute('app_validation', [
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
     * @throws Html2PdfException
     */
        public function validation(Request $request, IncidentsRepository $incidentsRepository): Response
        {
            $temp = $request->get('reponse');
            $num = $temp[0];
            $titre = $temp[3];
            $description=$temp[2];
            $date = $temp[4];
            $mail=$temp[1];

            $IPXapikey = "AZERTY";

            $message = "Titre: description: Date: ";


            //création d'un email de confirmation d'envoie de formulaire enregistrée
            /*$e_mail = (new TemplatedEmail())
                ->from('mairie@maisdon-sur-sevre.fr')
                ->to($mail)
                ->subject('Demande de voirie')
                ->htmlTemplate('emails/copyConfirmation.html.twig')
                ->context([
                    'date' => $date,
                    'titre' => $titre,
                    'description' => $description,
                ]);
            $mailer->send($e_mail);
*/
            //$var = $incidentsRepository->findOneBy(max(['id']));
            //dump($var);


            // envoyer une confirmation par sms si le num donnée est un smart
            if (substr($num, 0, 2) == '06' || substr($num, 0, 2) == '07') {
                $url = "https://sms.maisdon-sur-sevre.fr/api/xdevices.json?key=" . $IPXapikey . "&SetSMS=" . $num . ":" .$message."";

                return $this->render('home/validation.html.twig', [
                    'sms' => $url,
                    'ok'=> 'true',
                ]);
            }
            return $this->render('home/validation.html.twig', [
                    'sms' => 'valider',
                    'ok'=> 'false',
                    ]
            );
        }


}

