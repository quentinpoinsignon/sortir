<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(EventRepository $eventRepository)
    {
        $eventList = $eventRepository->findAll();
        return $this->render('main/home.html.twig', [
            "eventList" => $eventList
        ]);
    }

}
