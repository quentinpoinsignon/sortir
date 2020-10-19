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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/event_registration/{eventId}/{participantId}", name="event_registration")
     * @param EventRepository $eventRepository
     * @param RegistrationRepository $registrationRepository
     * @param UserRepository $userRepository
     * @param $eventId
     * @param $participantId
     * @param ValidatorInterface $validator
     * @return RedirectResponse
     */
public function eventRegistration(EventRepository $eventRepository, RegistrationRepository $registrationRepository, UserRepository $userRepository, $eventId, $participantId, ValidatorInterface $validator)

{
    $registration = new Registration();
    $event = $eventRepository->find($eventId);
    $user = $userRepository->find($participantId);
    $registration->setParticipant($user);
    $registration->setEvent($event);
    $errors = $validator->validate($registration);
    dump($errors);

        if(($event->getRegistrationLimitDate()>new DateTime()) && ($event->getRegistrationMaxNb()>count($event->getRegistrations()) && ($event->getState()->getLabel() =='Ouverte') &&count($errors)<1))
        {

            $registration->setRegistrationDate(new DateTime());
            $entityManager=  $this->getDoctrine()->getManager();
            $entityManager->persist($registration);
            $entityManager->flush();
            $this->addFlash('success', 'Félicitation, vous êtes inscrit à cette sortie');
        }
        else{
            $this->addFlash('error', 'Vous ne pouvez pas vous inscrire à cette sortie');
        }


    return $this->redirectToRoute('event_detail', ['id' => $event->getId()]);
}
}