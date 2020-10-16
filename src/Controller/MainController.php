<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home/{idAppUser}", requirements={"idAppUser"="\d+"}, name="home")
     */
    public function home(EventRepository $eventRepository, RegistrationRepository $registrationRepository, CampusRepository $campusRepository)
    {
        $eventList = $eventRepository->findAll();
        $registrationList = $registrationRepository->findAll();
        $campusList = $campusRepository->findAll();
        return $this->render('main/home.html.twig', [
            "eventList" => $eventList,
            "registrationList" => $registrationList,
            "campusList" => $campusList,
        ]);
    }

}
