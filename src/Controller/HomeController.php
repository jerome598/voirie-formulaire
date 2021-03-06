<?php

namespace App\Controller;

use App\Entity\Tincidents;
use App\Entity\User;
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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
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
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
        public function validation(Request $request, MailerInterface $mailer ): Response
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
            $mail = (new TemplatedEmail())
                ->from('mairie@maisdon-sur-sevre.fr')
                ->to($mail)
                ->subject('Demande de voirie')
                ->htmlTemplate('emails/copyConfirmation.html.twig')
                ->context([
                    'date' => $date,
                    'titre' => $titre,
                    'description' => $description,
                ]);
            $mailer->send($mail);

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
                'ok'=> 'false',]
            );
        }

    /**
     * @Route("/modifier/{id}", name="app_modifier_user")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function updateUser(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Compte modifié avec succès');
            return $this->redirectToRoute('app_register');
        }

        return $this->render('updateUser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/supprimer/{id}",name="app_supprimer_user")
     * @param User $user
     * @return Response
     */
    public function deleteUser(User $user): Response
    {
        $em =$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->render('app_register');
    }
}

