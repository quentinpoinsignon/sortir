<?php
namespace App\EventServices;

use App\Entity\Event;
use App\Repository\StateRepository;


class StateService
{
    private const CREATED_STATE = 'Créée';
    private const OPENED_STATE = 'Ouverte';
    private const CLOSED_STATE = 'Clôturée';
    private const IN_PROGRESS_STATE = 'Activité en cours';
    private const FINISHED_STATE = 'Passée';
    private const ARCHIVED_STATE = 'Archivée';
    private const CANCELED_STATE = 'Annulée';
    private StateRepository $stateRepository;

    /**
     * StateService constructor
     * @param StateRepository $stateRepository
     */
    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }


    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante CREATED_STATE
     */
            public function createdState(Event $event)
            {
                $state = $this->stateRepository->findOneBy(['label'=>self::CREATED_STATE]);
                $event->setState($state);
            }


            public function openedState(Event $event)
            {

            }


            public function closedState(Event $event){

            }

            public function inProgressState(Event $event){

            }

            public function finishedState(Event $event){


            }

            public function archivedState(Event $event){

            }

            public function canceledState(Event $event){


            }

}