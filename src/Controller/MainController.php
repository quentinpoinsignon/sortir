<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     *
     */
    public function home(Request $request, EventRepository $eventRepository, RegistrationRepository $registrationRepository, CampusRepository $campusRepository, UserRepository $userRepository)

    {

        $eventList = $eventRepository->findAll();
        $userList = $userRepository->findAll();
        $campusList = $campusRepository->findAll();
        $registrationList = $registrationRepository->findAll();
        //dd($eventList, $userList, $campusList, $registrationList);
        //coucou adeline :D

        return $this->render('main/home.html.twig', [
            "eventList" => $eventList,
            "registrationList" => $registrationList,
            "campusList" => $campusList,
            "userList" => $userList,
        ]);

    }

}
