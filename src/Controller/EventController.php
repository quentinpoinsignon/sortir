<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\Spot;
use App\Entity\State;
use App\Entity\Town;
use App\Form\EventAddFormType;
use App\Form\EventCancelFormType;
use App\Form\EventType;
use App\Form\HybridEventSpotFormType;
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
     * @author quentin
     * Fonction pour afficher le détail d'un event
     * @Route ("/detail/{id}", name="event_detail", methods={"GET"})
     */
    public function detail(int $id, EntityManagerInterface $entityManager, Request $request)
    {
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        $registrationRepository = $entityManager->getRepository(Registration::class);
        $registrations = $registrationRepository->findAll();

        return $this->render('event/event-detail.html.twig', [
            'event' => $event,
            'registrations' => $registrations,
        ]);
    }

    /**
     * @author quentin
     * Fonction pour créer un nouvel event
     * @Route("/add", name="event_add")
     * @Route ("/edit/{id}", name="event_edit")
     *
     */
    public function addEvent(int $id = null, EntityManagerInterface $entityManager, Request $request)
    {
//        $this->denyAccessUnlessGranted("ROLE_USER");

        // Récupération de la liste des villes
        $townRepository = $entityManager->getRepository(Town::class);
        $towns = $townRepository->findAll();
        $event = new Event();
        $spotRepository = $entityManager->getRepository(Spot::class);
        $spots = $spotRepository->findAll();

        $eventAddForm = $this->createForm(EventAddFormType::class, $event, ['use_type' => 'create']);
        $eventAddForm->handleRequest($request);

        if($eventAddForm->isSubmitted()) {
            if($eventAddForm->get('cancel')->isClicked())
            {
                dd('test');
            }
            if ($eventAddForm->isValid()) {
                //set de valeurs par défaut : state à créé
                $stateRepository = $entityManager->getRepository(State::class);
                $stateCreated = $stateRepository->findOneBy(['label' => 'Créée']);
                $event->setState($stateCreated);
                //owner à l'user connecté
                $event->setOwner($this->getUser());
                //campus au campus de l'user connecté
                $event->setCampus($this->getUser()->getCampus());

                //envoi à la base de données
                $entityManager->persist($event);
                $entityManager->flush();

                return $this->redirectToRoute("home");
            }
        }

        return $this->render('event/event-add.html.twig', [
            'eventAddForm' => $eventAddForm->createView(),
            'spots' => $spots,
            'towns' => $towns,
        ]);

    }

    /**
     * @author quentin
     * Fonction pour éditer un event
     * @Route ("/edit/{id}", name="event_edit", methods={"GET", "POST"})
     */
    public function editEvent(int $id, Request $request, EntityManagerInterface $entityManager) :Response
    {
        //récup de l'Event sélectionné via son id
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        //génération du formulaire avec l'event passé en paramètre
        $eventEditForm= $this->createForm(EventAddFormType::class, $event);
        $eventEditForm->handleRequest($request);

        //sauvegarde dans la base
        if ($eventEditForm->isSubmitted() && $eventEditForm->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
            //retour maison
            return $this->redirectToRoute('home');
        }

        return $this->render('event/event-edit.html.twig', [
            'eventEditForm' => $eventEditForm->createView(),
            'event' => $event,
        ]);
    }

    /**
     * @author quentin
     * Fonction de suppression d'un event
     * @Route ("/remove/{id}", name="event_remove", methods={"GET"})
     */
    public function removeEvent(int $id, EntityManagerInterface $entityManager)
    {
        //récup de l'event sélectionné via son id
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);
        //remove de l'event
        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @author quentin
     * Fonction d'annulation d'un event
     * @Route ("/cancel/{id}", name="event_cancel", methods={"GET", "POST"})
     */
    public function cancelEvent(int $id, EntityManagerInterface $entityManager, Request $request)
    {
        //récup de l'event sélectionné via son id
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        //génération du formulaire avec l'event passé en paramètre
        $eventCancelForm= $this->createForm(EventCancelFormType::class, $event);
        $eventCancelForm->handleRequest($request);

        //sauvegarde dans la base
        if ($eventCancelForm->isSubmitted() && $eventCancelForm->isValid()) {
            //Récup du state ouverte
            $stateRepository = $entityManager->getRepository(State::class);
            $stateCanceled = $stateRepository->findOneBy(['label' => 'Annulée']);
            $event->setState($stateCanceled);
            //sauvegarde en base
            $entityManager->persist($event);
            $entityManager->flush();
            //retour maison
            return $this->redirectToRoute('home');
        }

        return $this->render('event/event-cancel.html.twig', [
            'eventCancelForm' => $eventCancelForm->createView(),
            'event' => $event,
        ]);
    }

    /**
     * @author quentin
     * Fonction de publication d'un event
     * @Route ("/publish/{id}", name="event_publish", methods={"GET"})
     */
    public function publishEvent(int $id, EntityManagerInterface $entityManager)
    {
        //récup de l'event sélectionné via son id
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        //Récup du state ouverte
        $stateRepository = $entityManager->getRepository(State::class);
        $stateCreated = $stateRepository->findOneBy(['label' => 'Ouverte']);
        $event->setState($stateCreated);

        //remove de l'event
        $entityManager->persist($event);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }



}
