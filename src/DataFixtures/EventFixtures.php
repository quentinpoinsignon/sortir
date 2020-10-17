<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Spot;
use App\Entity\State;
use App\Entity\Town;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;

class EventFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {

        //**********************STATE*******************************************
        $state1 = new State();
        $state2 = new State();
        $state3 = new State();
        $state4 = new State();
        $state5 = new State();
        $state6 = new State();

        $state1->setLabel("Créée");
        $state2->setLabel("Overte");
        $state3->setLabel("Clôturée");
        $state4->setLabel("Activité en cours");
        $state5->setLabel("Passée");
        $state6->setLabel("Annulée");


        //**********************************EVENT************************************************
        $event1 = new Event();
        $event2 = new Event();
        $event3 = new Event();
        $event4 = new Event();
        $event5 = new Event();

        $event1->setName("Soirée Lazer Game");
        $event2->setName("Soirée Ciné!!");
        $event3->setName("Se réunir autour d'une dinde");
        $event4->setName("Trick or Treat");
        $event5->setName("Pool partyyyyyyyy");


        $event1->setStartDateTime(new \DateTime("2020-11-16T21:00:00"));
        $event2->setStartDateTime(new \DateTime("2020-10-25T21:00:00"));
        $event3->setStartDateTime(new \DateTime("2020-12-25T19:30:00"));
        $event4->setStartDateTime(new \DateTime("2020-10-31T22:00:00"));
        $event5->setStartDateTime(new \DateTime("2020-07-22T14:00:00"));

        $event1->setDuration(60);
        $event2->setDuration(120);
        $event3->setDuration(360);
        $event4->setDuration(240);
        $event5->setDuration(300);

        $event1->setRegistrationLimitDate(new \DateTime("2020-11-15T21:00:00"));
        $event2->setRegistrationLimitDate(new \DateTime("2020-10-24T21:00:00"));
        $event3->setRegistrationLimitDate(new \DateTime("2020-12-24T19:30:00"));
        $event4->setRegistrationLimitDate(new \DateTime("2020-10-30T22:00:00"));
        $event5->setRegistrationLimitDate(new \DateTime("2020-07-21T14:00:00"));

        $event1->setRegistrationMaxNb(12);
        $event2->setRegistrationMaxNb(20);
        $event3->setRegistrationMaxNb(6);
        $event4->setRegistrationMaxNb(10);
        $event5->setRegistrationMaxNb(30);

        $event1->setState($state1);
        $event2->setState($state6);
        $event3->setState($state1);
        $event4->setState($state2);
        $event5->setState($state5);

        $spot1 = new Spot();
        $spot1->setName('Melody Nelson');
        $spot1->setStreet('4 Rue Saint-Thomas');
        $spot1->setLatitude(48.108455);
        $spot1->setLongitude(-1.675147);
        $town1 = new Town();
        $town1->setName('Rennes');
        $town1->setPostalCode('35000');
        $spot1->setTown($town1);

        $spot2 = new Spot();
        $spot2->setName('Gameover');
        $spot2->setStreet('1 Rue Lebrun');
        $spot2->setLatitude(47.220173);
        $spot2->setLongitude(-1.548964);
        $town2 = new Town();
        $town2->setName('Nantes');
        $town2->setPostalCode('44000');
        $spot2->setTown($town2);

        $spot3 = new Spot();
        $spot3->setName('L\'instant Jeux');
        $spot3->setStreet('19 rue Georges Clémenceau');
        $spot3->setLatitude(46.977119);
        $spot3->setLongitude(-1.313038);
        $town3 = new Town();
        $town3->setName('Montaigu');
        $town3->setPostalCode('85600');
        $spot3->setTown($town3);


        $event1->setSpot($spot1);
        $event2->setSpot($spot2);
        $event3->setSpot($spot3);
        $event4->setSpot($spot2);
        $event5->setSpot($spot3);

        //**********************CAMPUS********************************
//        $campus1 = new Campus();
//        $campus1->setName("Chartres de Bretagne");
//
//        $campus2 = new Campus();
//        $campus2->setName("Saint Herblain");
//
//        $campus3 = new Campus();
//        $campus3->setName("La Roche sur Yon");

//        $event1->setCampus(CampusFixtures::class->$campus1);
//        $event2->setCampus($campus2);
//        $event3->setCampus($campus3);
//        $event4->setCampus($campus1);
//        $event5->setCampus($campus2);
        //*********************************************************************

        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);
        $manager->persist($event4);
        $manager->persist($event5);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['event'];
    }
}
