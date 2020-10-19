<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CampusRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request, EventRepository $eventRepository, RegistrationRepository $registrationRepository, CampusRepository $campusRepository, UserRepository $userRepository)

    {


        $userList = $userRepository->findAll();
        $campusList = $campusRepository->findAll();
        $registrationList = $registrationRepository->findAll();

        $campusChoiceId = $request->get('campus_list');
        $search = $request->get('search_input');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');
        $userOrganisateur = $request->get('user_organisateur');
        $userInscrit = $request->get('user_inscrits');
        $userNonInscrit = $request->get('user_non_inscrits');
        $sortiesPassees = $request->get('sorties_passees');
        $idUser = $this->getUser()->getId();
        $user = $this->getUser();


        $eventList = $eventRepository->findEventBySearchFilters($request, $this->getUser());

//méthode pour tester une requête en fonction d'une checkbox / date ou autres

        //dump($dateFin);
//
       // if($request->get('user_inscrits' == 'on'))
        //{
//            $myEventList = $eventRepository->findEventUserNotRegistered($this->getUser());
//            dump($myEventList);
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
