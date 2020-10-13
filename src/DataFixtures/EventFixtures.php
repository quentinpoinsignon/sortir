<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;

class EventFixtures extends Fixture
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


        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);
        $manager->persist($event4);


        $manager->flush();
    }
}
