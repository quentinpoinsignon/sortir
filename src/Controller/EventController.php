<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\Spot;
use App\Form\EventAddFormType;
use App\Form\EventType;
use App\Form\HybridEventSpotFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @author quentin
     * Fonction pour afficher le détail d'un event
     *
     * @Route ("/detail/{id}", name="event_detail", methods={"GET"})
     */
    public function detail(int $id, EntityManagerInterface $entityManager, Request $request)
    {
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        $registrationRepository = $entityManager->getRepository(Registration::class);
        $registrations = $registrationRepository->findAll();

        return $this->render('event/detail.html.twig', [
            'event' => $event,
            'registrations' => $registrations,
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @author quentin
     * Fonction pour créer une nouvelle sortie
     * @Route("/add", name="event_add")
     */
    public function addEvent(EntityManagerInterface $entityManager, Request $request)
    {
//        $this->denyAccessUnlessGranted("ROLE_USER");


        $event = new Event();
        $spot = new Spot();

        $eventAddForm = $this->createForm(EventAddFormType::class, $event);
        $eventAddForm->handleRequest($request);


        if($eventAddForm->isSubmitted() && $eventAddForm->isValid())
        {
            //envoi à la base de données
            $entityManager->persist($event);
            $entityManager->flush();
            // message Flash
            $this->addFlash("green", "New event registered !");

            return $this->redirectToRoute("home");
        }

        return $this->render('event/add.html.twig', [
            "eventAddForm" => $eventAddForm->createView()
        ]);

    }



}
