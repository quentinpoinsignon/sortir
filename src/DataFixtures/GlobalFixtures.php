<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Spot;
use App\Entity\State;
use App\Entity\Town;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class GlobalFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        // Towns
        $town1 = new Town();
        $town1->setName('Rennes');
        $town1->setPostalCode('35000');
        $town2 = new Town();
        $town2->setName('Nantes');
        $town2->setPostalCode('44000');
        $town3 = new Town();
        $town3->setName('Montaigu');
        $town3->setPostalCode('85600');



        // Spots
        $spot1 = new Spot();
        $spot1->setName('Melody Nelson');
        $spot1->setStreet('4 Rue Saint-Thomas');
        $spot1->setLatitude(48.108455);
        $spot1->setLongitude(-1.675147);
        $spot1->setTown($town1);
        $manager->persist($spot1);

        $spot2 = new Spot();
        $spot2->setName('Gameover');
        $spot2->setStreet('1 Rue Lebrun');
        $spot2->setLatitude(47.220173);
        $spot2->setLongitude(-1.548964);
        $spot2->setTown($town2);
        $manager->persist($spot2);

        $spot3 = new Spot();
        $spot3->setName('L\'instant Jeux');
        $spot3->setStreet('19 rue Georges Clémenceau');
        $spot3->setLatitude(46.977119);
        $spot3->setLongitude(-1.313038);
        $spot3->setTown($town3);
        $manager->persist($spot3);

        //Campus
        $campus1 = new Campus();
        $campus1->setName("Chartres de Bretagne");
        $campus2 = new Campus();
        $campus2->setName("Saint Herblain");
        $campus3 = new Campus();
        $campus3->setName("La Roche sur Yon");

        $user = new User();
        $user->setFirstName("toto");
        $user->setName("gargamel");
        $user->setEmailAdress("toto.gargamel@mail.fr");
        $user->setActive(true);
        $user->setAdministrator(false);
        $user->setPassword("toto");
        $user->setPhoneNumber("0645879632");
        $user->setRoles(['ROLE_USER']);
        $user->setUsername("toto");
        $user->setCampus($campus1);


        $user2 = new User();
        $user2->setFirstName("rico");
        $user2->setName("pantagruel");
        $user2->setEmailAdress("rico.pantagruel@mail.fr");
        $user2->setActive(true);
        $user2->setAdministrator(false);
        $user2->setPassword("G435HNDSEGY");
        $user2->setPhoneNumber("0458972596");
        $user2->setRoles(['ROLE_USER']);
        $user2->setUsername("ricolagaffe");
        $user2->setCampus($campus2);

        $user3 = new User();
        $user3->setFirstName("jojo");
        $user3->setName("fafaron");
        $user3->setEmailAdress("fanfaron.jojo@mail.fr");
        $user3->setActive(true);
        $user3->setAdministrator(false);
        $user3->setPassword("hgey595866gdffr");
        $user3->setPhoneNumber("0548965235");
        $user3->setRoles(['ROLE_USER']);
        $user3->setUsername("jojolasticot");
        $user3->setCampus($campus3);


        // State
        $state1 = new State();
        $state2 = new State();
        $state3 = new State();
        $state4 = new State();

        $state1->setLabel("Crée");
        $state2->setLabel("Ouverte");
        $state3->setLabel("Activité en cours");
        $state4->setLabel("Ouverte");

        // Event
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

        $event1->setState($state1);
        $event2->setState($state2);
        $event3->setState($state3);
        $event4->setState($state4);

        $event1->setSpot($spot1);
        $event2->setSpot($spot2);
        $event3->setSpot($spot3);
        $event4->setSpot($spot2);

        $event1->setCampus($campus1);
        $event2->setCampus($campus2);
        $event3->setCampus($campus3);
        $event4->setCampus($campus2);

        $event1->setOwner($user);
        $event2->setOwner($user2);
        $event3->setOwner($user3);
        $event4->setOwner($user2);


        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);
        $manager->persist($event4);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['global'];
    }
}
