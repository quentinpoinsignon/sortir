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

    public function __construct(EventRepository $eventRepository, StateService $stateService, EntityManager $entityManager)
    {
        $this->eventRepository = $eventRepository;
        $this->stateService = $stateService;
        $this->entityManager = $entityManager;
    }


    public function onSecurityAuthenticationSuccess(AuthenticationEvent $authenticationEvent)
    {
            $now = new \DateTime();

        $openEventsToUpload = $this->eventRepository->findEventByStateLabel('Ouverte');
        foreach ($openEventsToUpload as $event) {
            dump($event->getStartDateTime());
            dump(date_sub($event->getStartDateTime(), new DateInterval($this->registerLimitTime)));
            if ($event->getStartDateTime()<=(date_sub($event->getStartDateTime(), new DateInterval($this->registerLimitTime)))) {
                $this->stateService->closedState($event);
                dump($event);
                $this->entityManager->flush();
            }
        }

     dump(   $closedEventsToUpload = $this->eventRepository->findEventByStateLabel('Clôturée'));
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
        }
    }


    public static function getSubscribedEvents()
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onSecurityAuthenticationSuccess',
        ];
    }
}
