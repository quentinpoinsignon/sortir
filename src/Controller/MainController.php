<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(EventRepository $eventRepository, RegistrationRepository $registrationRepository)
    {
        $eventList = $eventRepository->findAll();
        $registrationList = $registrationRepository->findAll();
        return $this->render('main/home.html.twig', [
            "eventList" => $eventList,
            "registrationList" => $registrationList,
        ]);
    }



}
