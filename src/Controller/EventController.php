<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\Spot;
use App\Entity\State;
use App\Entity\Town;
Use App\EventServices\StateService as StateService;
use App\Form\EventAddFormType;
use App\Form\EventCancelFormType;
use App\Form\EventType;
use App\Form\HybridEventSpotFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param int|null $id
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param StateService $stateService
     * @return RedirectResponse|Response
     * @author quentin
     * Fonction pour créer un nouvel event
     * @Route("/add", name="event_add")
     * @Route ("/edit/{id}", name="event_edit")
     */
    
    public function addEvent(int $id = null, EntityManagerInterface $entityManager, Request $request, StateService  $stateService)
    {
//       $this->denyAccessUnlessGranted("ROLE_USER");
        // Récupération de la liste des villes
        $townRepository = $entityManager->getRepository(Town::class);
        $towns = $townRepository->findBy(array(), array('name' =>'ASC'));
        $event = new Event();
        $spotRepository = $entityManager->getRepository(Spot::class);
        $spots = $spotRepository->findAll();

        $eventAddForm = $this->createForm(EventAddFormType::class, $event);
        $eventAddForm->handleRequest($request);

        if ($eventAddForm->isSubmitted() && $eventAddForm->isValid()) {

                //Appel du service StateService permettant de définir l'attribut "state" à "Créée"
                $stateService->createdState($event);

                    //set de valeurs par défaut : state à créé
                    $stateRepository = $entityManager->getRepository(State::class);
                    $stateCreated = $stateRepository->findOneBy(['label' => 'Créée']);
                    $event->setState($stateCreated);
                    //owner à l'user connecté
                    $event->setOwner($this->getUser());
                    //campus au campus de l'user connecté
                    $event->setCampus($this->getUser()->getCampus());
                    // spot depuis la sélection de l'user
                    $spot = $spotRepository->find($request->request->get('selectedSpotId'));
                    $event->setSpot($spot);
                    //envoi à la base de données
                    $entityManager->persist($event);
                    $entityManager->flush();

                    $this->addFlash('success', 'Nouvel évènement enregistré !' . $event->getName());

                    return $this->redirectToRoute("home");

        }

            return $this->render('event/event-add.html.twig', [
                'eventAddForm' => $eventAddForm->createView(),
                'towns' => $towns,
                'spots' => $spots,
            ]);

}


    /**
     * @author quentin
     * Fonction pour éditer un event
     * @Route ("/edit/{id}", name="event_edit", methods={"GET", "POST"})
     */
    public function editEvent(int $id, Request $request, EntityManagerInterface $entityManager) :Response
    {
        $townRepository = $entityManager->getRepository(Town::class);
        $towns = $townRepository->findBy(array(), array('name' =>'ASC'));

        $spotRepository = $entityManager->getRepository(Spot::class);
        $spots = $spotRepository->findAll();

        //récup de l'Event sélectionné via son id
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        //récup du lieu pré-sélectionné
        $selectedSpot = $event->getSpot();

        //récup de la ville pré-sélectionnée
        $selectedTown = $event->getSpot()->getTown();

        //génération du formulaire avec l'event passé en paramètre
        $eventEditForm= $this->createForm(EventAddFormType::class, $event);
        $eventEditForm->handleRequest($request);

        //sauvegarde dans la base
        if ($eventEditForm->isSubmitted() && $eventEditForm->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
            //retour maison
            $this->addFlash('success', 'La sortie ' . $event->getName() . ' a été modifiée');
            return $this->redirectToRoute('home');
        }

        return $this->render('event/event-edit.html.twig', [
            'eventEditForm' => $eventEditForm->createView(),
            'event' => $event,
            'towns' => $towns,
            'spots' => $spots,
            'selectedSpot' => $selectedSpot,
            'selectedTown' => $selectedTown,
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

        return $this->redirectToRoute('event_edit', [
            'id' => $event->getId(),
        ]);
    }



}
