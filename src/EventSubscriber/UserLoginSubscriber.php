<?php

namespace App\EventSubscriber;

use App\EventServices\StateService;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserLoginSubscriber implements EventSubscriberInterface
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
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $openedEventsToUpload = $this->eventRepository->findEventByStateLabel('Ouverte');
        foreach($openedEventsToUpload as $event)
        {
            $eventFinishingDate = date_add($event->getStartDateTime(), new\DateInterval('P' . $event->getDuration() . 'M'));

            if($event->getStartDateTime()<=date("Y/m/d") && $eventFinishingDate >= date("Y/m/d")){
                $this->stateService->inProgressState($event);
                try {
                    $this->entityManager->persist($event);
                } catch (ORMException $e) {
                }
                try {
                    $this->entityManager->flush();
                } catch (OptimisticLockException $e) {
                } catch (ORMException $e) {
                }
            }

        }

        $inProgressEventsToUpload =  $this->eventRepository->findEventByStateLabel('En cours');
        foreach ($inProgressEventsToUpload as $event){
            try {
                if (date_add($event->getStartDateTime(), new \DateInterval('P' . $event->getDuration() . 'M')) < date("Y/m/d")) {
                    $this->stateService->finishedState($event);
                    try {
                        $this->entityManager->persist($event);
                    } catch (ORMException $e) {
                        $e->getMessage('erreur lors de la sauvegarge de la sortie');
                    }
                    try {
                        $this->entityManager->flush();
                    } catch (OptimisticLockException $e) {
                        $e->getMessage('erreur lors de la sauvegarge de la sortie');
                    } catch (ORMException $e) {
                        $e->getMessage('erreur lors de la sauvegarge de la sortie');
                    }
                }
            } catch (\Exception $e) {
            }
        }

        $finishedEventsToUpload =  $this->eventRepository->findEventByStateLabel('Terminée');
        foreach ($finishedEventsToUpload as $event){
            if(date_diff($event->getStartDateTime(), $eventFinishingDate)>=30){
                $this->stateService->archivedState();
            }
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            'security.interactive_login' => 'onSecurityInteractiveLogin',
        ];
    }
}
