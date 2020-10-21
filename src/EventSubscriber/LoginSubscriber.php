<?php

namespace App\EventSubscriber;

use App\EventServices\StateService;
use App\Repository\EventRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private $eventRepository;
    private $entityManager;
    private $stateService;

    public function __construct(EventRepository $eventRepository, StateService $stateService, EntityManager $entityManager)
    {

        $this->eventRepository = $eventRepository;
        $this->stateService = $stateService;
        $this->entityManager = $entityManager;
    }


    public function onSecurityAuthenticationSuccess(AuthenticationEvent $authenticationEvent)
    {
       $openEventsToUpload = $this->eventRepository->findEventByStateLabel('Ouverte');

        foreach($openEventsToUpload as $event)
        {
            if($event->getStartDateTime()<=(date_sub($event->getStartDateTime(), new DateInterval('PT24H'))))
                {
                $this->stateService->closedState($event);

            $this->entityManager->flush();
        }
        }

        $closedEventsToUpload = $this->eventRepository->findEventByStateLabel('Clôturée');
        foreach($closedEventsToUpload as $event) {
            try {
                $eventFinishingDate = date_add($event->getStartDateTime(), new DateInterval('P' . $event->getDuration() . 'M'));


                if ($event->getStartDateTime() <= date("Y/m/d") && $eventFinishingDate >= date("Y/m/d")) {
                    $this->stateService->inProgressState($event);

                    $this->entityManager->flush();
                }

            } catch (Exception $e) {
            }
        }
        $inProgressEventsToUpload =  $this->eventRepository->findEventByStateLabel('En cours');
        foreach ($inProgressEventsToUpload as $event) {
            try {
                if (date_add($event->getStartDateTime(), new DateInterval('P' . $event->getDuration() . 'M')) < date("Y/m/d")) {
                    $this->stateService->finishedState($event);


                    $this->entityManager->flush();

                }
            } catch (Exception $e) {
            }
        }

        $finishedEventsToUpload =  $this->eventRepository->findEventByStateLabel('Terminée');
        foreach ($finishedEventsToUpload as $event) {
            try {
                $eventFinishingDate = date_add($event->getStartDateTime(), new DateInterval('P' . $event->getDuration() . 'M'));

            if (date_diff($event->getStartDateTime(), $eventFinishingDate) >= new DateInterval('P1M')) {
                $this->stateService->archivedState($event);

                $this->entityManager->flush();
            }
            } catch (Exception $e) {
            }}
    }


    public static function getSubscribedEvents()
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}


