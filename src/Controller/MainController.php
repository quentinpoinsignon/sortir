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
     */
    public function home(Request $request, EventRepository $eventRepository, RegistrationRepository $registrationRepository, CampusRepository $campusRepository, UserRepository $userRepository)

    {

        $eventList = $eventRepository->findAll();
        $userList = $userRepository->findAll();
        $campusList = $campusRepository->findAll();
        $registrationList = $registrationRepository->findAll();


//        dd($eventList, $userList, $campusList, $registrationList);

//méthodo pour tester une requête en fonction d'une checkbox / date ou autres
//        $dateDebut = $request->get('date_debut');
//        $value = $request->get("user_organisateur");
//
//        if($request->get('sorties_passees') == 'on')
//        {
//            $eventList =$eventRepository->findClosedEvents();
//        }



        return $this->render('main/home.html.twig', [
            "eventList" => $eventList,
            "registrationList" => $registrationList,
            "campusList" => $campusList,
            "userList" => $userList,
            "request" => $request,
        ]);

    }

}
