<?php

namespace App\DataFixtures;

use App\Entity\Spot;
use App\Entity\Town;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;

class EventFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event2 = new Event();
        $event3 = new Event();
        $event4 = new Event();

        $event1->setName("Soirée Lazer Game");
        $event2->setName("Soirée Ciné!!");
        $event3->setName("Se réunir autour d'une dinde");
        $event4->setName("Trick or Treat");

        $event1->setStartDateTime(new \DateTime("2020-11-16T21:00:00"));
        $event2->setStartDateTime(new \DateTime("2020-10-25T21:00:00"));
        $event3->setStartDateTime(new \DateTime("2020-12-25T19:30:00"));
        $event4->setStartDateTime(new \DateTime("2020-10-31T22:00:00"));

        $event1->setDuration(60);
        $event2->setDuration(120);
        $event3->setDuration(360);
        $event4->setDuration(240);

        $event1->setRegistrationLimitDate(new \DateTime("2020-11-15T21:00:00"));
        $event2->setRegistrationLimitDate(new \DateTime("2020-10-24T21:00:00"));
        $event3->setRegistrationLimitDate(new \DateTime("2020-12-24T19:30:00"));
        $event4->setRegistrationLimitDate(new \DateTime("2020-10-30T22:00:00"));

        $event1->setRegistrationMaxNb(12);
        $event2->setRegistrationMaxNb(20);
        $event3->setRegistrationMaxNb(6);
        $event4->setRegistrationMaxNb(10);

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


        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);
        $manager->persist($event4);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['event'];
    }
}
