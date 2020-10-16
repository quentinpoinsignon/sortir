<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\Spot;
use App\Entity\State;
use App\Entity\Town;
use App\Form\EventAddFormType;
use App\Form\EventType;
use App\Form\HybridEventSpotFormType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param UserInterface $user
     * @return RedirectResponse|Response
     * @author quentin
     * Fonction pour créer une nouvelle sortie
     * @Route("/add", name="event_add")
     */
    public function addEvent(EntityManagerInterface $entityManager, Request $request)
    {
//        $this->denyAccessUnlessGranted("ROLE_USER");

        // Récupération de la liste des villes
        $townRepository = $entityManager->getRepository(Town::class);
        $towns = $townRepository->findAll();
        $event = new Event();
        $spot = new Spot();

        $eventAddForm = $this->createForm(EventAddFormType::class, $event);
        $eventAddForm->handleRequest($request);


        if($eventAddForm->isSubmitted() && $eventAddForm->isValid())
        {
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

        return $this->render('event/add.html.twig', [
            'eventAddForm' => $eventAddForm->createView()
        ]);

    }

    /**
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     * @author quentin
     * Fonction pour éditer une sortie
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

        return $this->render('event/edit.html.twig', [
            'eventEditForm' => $eventEditForm->createView(),
            'event' => $event,
        ]);
    }

    /**
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
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
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     * @author quentin
     * Fonction d'annulation'd'un event
     * @Route ("/cancel/{id}", name="event_cancel", methods={"GET"})
     */

    public function cancelEvent(int $id, EntityManagerInterface $entityManager)
    {
        //récup de l'event sélectionné via son id
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);
        //remove de l'event
        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

}
