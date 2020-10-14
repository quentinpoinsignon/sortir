<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Form\EventFormType;
use App\Form\EventType;
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

        //Instanciation de l'objet à entrer en BDD + formulaire
        $event = new Event();
        //valeur par défaut qui va s'afficher dans le form !
        //ici, le pseudo du user connecté
//        $event->setOwner($this->getUser()->getUsername());
        $eventForm = $this->createForm(EventFormType::class, $event);
        $eventForm->handleRequest($request);

        //si le formulaire est envoyé, set des valeurs par défaut de published et date
        if($eventForm->isSubmitted() && $eventForm->isValid())
        {
//            $idea->setDateCreated(new \DateTime());

            //envoi à la base de données
            $entityManager->persist($event);
            $entityManager->flush();
            // message Flash
            $this->addFlash("green", "New event registered !");

            return $this->redirectToRoute("home");
        }

        return $this->render('event/add.html.twig', [
            "eventForm" => $eventForm->createView()
        ]);

    }



}
