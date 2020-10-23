<?php

namespace App\EventSubscriber;

use App\EventServices\StateService;
use App\Repository\EventRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StateUploadSubscriber implements EventSubscriberInterface
{
    private EventRepository $eventRepository;
    private EntityManager $entityManager;
    private StateService $stateService;
    private const CREATED_STATE = 'Créée';
    private const OPENED_STATE = 'Ouverte';
    private const CLOSED_STATE = 'Clôturée';
    private const IN_PROGRESS_STATE = 'En cours';
    private const FINISHED_STATE = 'Terminée';

    public function __construct(EventRepository $eventRepository, StateService $stateService, EntityManager $entityManager)
    {
        $this->eventRepository = $eventRepository;
        $this->stateService = $stateService;
        $this->entityManager = $entityManager;
    }


    /**
     * @param ControllerEvent $event
     * @throws \Exception
     * @author kim
     * Appelle le StateService pour mettre à jour les statuts de tous les events en base de données en fonction de
     * l'intitulé du statut actuel, des dates de sortie, de clôture et
     * de fin de sortie de chaque event à chaque fois que l'évènement ControllerEvent se produit.
     */
    public function onKernelController(ControllerEvent $event)
    {
            $now = new \DateTime();
            //Récupération de tous les events en base de données
            $allEvent = $this->eventRepository->findAll();


            foreach ($allEvent as $event)
            {

                $startingDate = $event->getStartDateTime();
                $startingDateclone = clone $startingDate;
                $finishingDate = date_add($startingDateclone, new DateInterval('PT'.$event->getDuration().'M'));



                //récupération des évènements publiés
                if($event->getState()->getLabel()==self::OPENED_STATE){

                    //test si la date de début de l'évènement est dans moins de 24h
                    if($event->getRegistrationLimitDate()<= $now)
                    {
                        //appel du stateService pour changement du statut de la sortie si le test est vrai
                        $this->stateService->closedState($event);

                    }

                }
                //récupération des évènements clôturés
                if($event->getState()->getLabel()==self::CLOSED_STATE)
                {

                    //test si la date de début de l'évènement est antéreure à maintenant et si la date de fin est postérieure à maintenant
                    if($event->getStartDateTime()<=$now && $finishingDate>=$now)
                    {
                        //appel du stateService pour changement du statut de la sortie si le test est vrai
                        $this->stateService->inProgressState($event);

                    }
                }
                //récupération des évènements en cours
                if ($event->getState()->getLabel()==self::IN_PROGRESS_STATE){

                    //test si la date de fin de l'évènement est antérieur à maintenant
                    if ($finishingDate<$now)
                    {
                        //appel du stateService pour changement du statut de la sortie si le test est vrai
                        $this->stateService->finishedState($event);

                    }
                }

                //récupération des évènements terminés
                if ($event->getState()->getLabel()==self::FINISHED_STATE)
                {

                    if ((date_diff($now,$event->getStartDateTime())->days)>30)
                    {
                        $this->stateService->archivedState($event);

                    }
                }
                $this->entityManager->flush();
            }

    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
