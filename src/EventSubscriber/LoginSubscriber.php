<?php

namespace App\EventSubscriber;

use App\EventServices\StateService;
use App\Repository\EventRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\AuthenticationEvents;

class LoginSubscriber implements EventSubscriberInterface
{
    private EventRepository $eventRepository;
    private EntityManager $entityManager;
    private StateService $stateService;
    private $registerLimitTime = 'PT24H';
    private const CREATED_STATE = 'Créée';
    private const OPENED_STATE = 'Ouverte';
    private const CLOSED_STATE = 'Clôturée';
    private const IN_PROGRESS_STATE = 'En cours';
    private const FINISHED_STATE = 'Terminée';
    private const ARCHIVED_STATE = 'Archivée';
    private const CANCELED_STATE = 'Annulée';

    public function __construct(EventRepository $eventRepository, StateService $stateService, EntityManager $entityManager)
    {
        $this->eventRepository = $eventRepository;
        $this->stateService = $stateService;
        $this->entityManager = $entityManager;
    }


    public function onSecurityAuthenticationSuccess(AuthenticationEvent $authenticationEvent)
    {
            $now = new \DateTime();
            $allEvent = $this->eventRepository->findAll();
            dump($allEvent);

            foreach ($allEvent as $event)
            {
                dump($event);
                $startingDate = $event->getStartDateTime();
                $startingDateclone = clone $startingDate;
                $finishingDate = date_add($startingDateclone, new DateInterval('PT'.$event->getDuration().'M'));
                dump($startingDate);
                dump($startingDateclone);
                dump($finishingDate);


                //récupération des évènements publiés
                if($event->getState()->getLabel()==self::OPENED_STATE){
                    dump($event);
                    //test si la date de début de l'évènement est dans moins de 24h
                    if((date_diff($now,$startingDateclone)->days)<1)
                    {
                        //appel du stateService pour changement du statut de la sortie si le test est vrai
                        $this->stateService->closedState($event);
                        dump($event);
                    }

                }
                //récupération des évènements clôturés
                if($event->getState()->getLabel()==self::CLOSED_STATE)
                {
                    dump($event);
                    //test si la date de début de l'évènement est antéreure à maintenant et si la date de fin est postérieure à maintenant
                    if($event->getStartDateTime()<=$now && $finishingDate>=$now)
                    {
                        //appel du stateService pour changement du statut de la sortie si le test est vrai
                        $this->stateService->inProgressState($event);
                        dump($event);
                    }
                }
                //récupération des évènements en cours
                if ($event->getState()->getLabel()==self::IN_PROGRESS_STATE){
                    dump($event);
                    //test si la date de fin de l'évènement est antérieur à maintenant
                    if ($finishingDate<$now)
                    {
                        //appel du stateService pour changement du statut de la sortie si le test est vrai
                        $this->stateService->finishedState($event);
                        dump($event);
                    }
                }

                //récupération des évènements terminés
                if ($event->getState()->getLabel()==self::FINISHED_STATE)
                {
                    dump($event);
                    if ((date_diff($now,$event->getStartDateTime())->days)>30)
                    {
                        $this->stateService->archivedState($event);
                        dump($event);
                    }
                }
                $this->entityManager->flush();
            }



/*        $openEventsToUpload = $this->eventRepository->findEventByStateLabel('Ouverte');
        foreach ($openEventsToUpload as $event) {
            $start = $event->getStartDateTime();
            dump($event->getStartDateTime());
            dump(date_sub($start, new DateInterval($this->registerLimitTime)));
            if ($event->getStartDateTime()<=(date_sub($start, new DateInterval($this->registerLimitTime)))) {
                $this->stateService->closedState($event);
                dump($event);
                $this->entityManager->flush();
            }
        }

     dump($closedEventsToUpload = $this->eventRepository->findEventByStateLabel('Clôturée'));
        foreach ($closedEventsToUpload as $event) {
            try {
                $start = $event->getStartDateTime();
                $eventFinishingDate = date_add($start, new DateInterval('PT' . $event->getDuration() . 'M'));
                dump($event->getStartDateTime());
                dump($eventFinishingDate);
                dump($now);
                if (($event->getStartDateTime() <= $now) && ($eventFinishingDate >= $now)) {
                    dump($event);
                    $this->stateService->inProgressState($event);

                    $this->entityManager->flush();
                }
            } catch (Exception $e) {
            }
        }
        $inProgressEventsToUpload =  $this->eventRepository->findEventByStateLabel('En cours');
        foreach ($inProgressEventsToUpload as $event) {
            try {
                dump(new DateInterval('PT' . $event->getDuration() . 'M'));
                if (date_add($event->getStartDateTime(), new DateInterval('PT' . $event->getDuration() . 'M')) < $now) {
                    $this->stateService->finishedState($event);
                    dump($event);
                    $this->entityManager->flush();
                }
            } catch (Exception $e) {
            }
        }

        $finishedEventsToUpload =  $this->eventRepository->findEventByStateLabel('Terminée');
        foreach ($finishedEventsToUpload as $event) {
            try {
                $eventFinishingDate = date_add($event->getStartDateTime(), new DateInterval('PT' . $event->getDuration() . 'M'));
                if (date_diff($event->getStartDateTime(), $eventFinishingDate) >= new DateInterval('P1M')) {
                    $this->stateService->archivedState($event);
                    dump($event);
                    $this->entityManager->flush();
                }
            } catch (Exception $e) {
            }
        }*/
    }


    public static function getSubscribedEvents()
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onSecurityAuthenticationSuccess',
        ];
    }
}
