<?php
namespace App\EventServices;

use App\Entity\Event;
use App\Repository\StateRepository;

class StateService
{
    private const CREATED_STATE = 'Créée';
    private const OPENED_STATE = 'Ouverte';
    private const CLOSED_STATE = 'Clôturée';
    private const IN_PROGRESS_STATE = 'En cours';
    private const FINISHED_STATE = 'Terminée';
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


    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante OPENED_STATE
     */
    public function openedState(Event $event)
    {
        $state = $this->stateRepository->findOneBy(['label' => self::OPENED_STATE]);
        $event->setState($state);
    }


    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante CLOSED_STATE
     */
    public function closedState(Event $event)
    {
        $state= $this->stateRepository->findOneBy(['label'=>self::CLOSED_STATE]);
        $event->setState($state);
    }

    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante IN_PROGRESS_STATE
     */
    public function inProgressState(Event $event)
    {
        $state= $this->stateRepository->findOneBy(['label'=>self::IN_PROGRESS_STATE]);
        $event->setState($state);
    }

    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante FINISHED_STATE
     */
    public function finishedState(Event $event)
    {
        $state= $this->stateRepository->findOneBy(['label'=>self::FINISHED_STATE]);
        $event->setState($state);
    }

    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante ARCHIVED_STATE
     */
    public function archivedState(Event $event)
    {
        $state= $this->stateRepository->findOneBy(['label'=>self::ARCHIVED_STATE]);
        $event->setState($state);
    }

    /**
     * @param Event $event
     * @author kim
     * Définit l'attribut "state" de l'instance de classe "Event" passée en argument à la
     * valeur de la constante CANCELED_STATE
     */
    public function canceledState(Event $event)
    {
        $state=$this->stateRepository->findOneBy(['label' =>self::CANCELED_STATE]);
        $event->setState($state);
    }

}
