<?php
namespace App\Controller;


use App\Entity\Registration;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/event_registration/{eventId}/{participantId}", name="event_registration")
     * @param EventRepository $eventRepository
     * @param RegistrationRepository $registrationRepository
     * @param UserRepository $userRepository
     * @param $eventId
     * @param $participantId
     * @return RedirectResponse
     */
public function eventRegistration(EventRepository $eventRepository, RegistrationRepository $registrationRepository, UserRepository $userRepository, $eventId, $participantId)

{
    $registration = new Registration;
    $event = $eventRepository->find($eventId);
    $user = $userRepository->find($participantId);
       if(($event->getRegistrationLimitDate()>new DateTime()) && ($event->getRegistrationMaxNb()>$event->getRegistrations()->count()) && ($event->getState()->getLabel() =='ouverte'))
       {
           $registration->setParticipant($user);
           $this->addFlash('registrationSuccess', 'Félicitation, vous êtes inscrit à cette sortie');
       }
       else{
           $this->addFlash('registrationError', 'Vous ne pouvez pas vous inscrire à cette sortie');
       }
    return $this->redirectToRoute('event_detail', ['id' => $event->getId()]);
}
}