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


        //Récupérer les données du formulaire
        if($request->get('search_input') != null) {
            $campusChoiceId = $request->get('campus_list');
            $search = $request->get('search_input');
            $dateDebut = $request->get('date_debut');
            $dateFin = $request->get('date_fin');
            $userOrganisateur = $request->get('user_organisateur');
            $userInscrit = $request->get('user_inscrits');
            $userNonInscrit = $request->get('user_non_inscrits');
            $sortiesPassees = $request->get('sorties_passees');
        }
//méthodo pour tester une requête en fonction d'une checkbox / date ou autres

//        dump($request->get('user_inscrits'));
//
       // if($request->get('user_inscrits' == 'on'))
        //{
            $myEventList = $eventRepository->findEventByStateLabel('Ouverte');
            dump($myEventList);
       // }



        return $this->render('main/home.html.twig', [
            "eventList" => $eventList,
            "registrationList" => $registrationList,
            "campusList" => $campusList,
            "userList" => $userList,
            "request" => $request,
        ]);

    }

}
