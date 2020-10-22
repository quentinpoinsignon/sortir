<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\Spot;
use App\Entity\State;
use App\Entity\Town;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GlobalFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // Towns*****************************************************************************
        $town1 = new Town();
        $town1->setName('Rennes');
        $town1->setPostalCode('35000');
        $town2 = new Town();
        $town2->setName('Nantes');
        $town2->setPostalCode('44000');
        $town3 = new Town();
        $town3->setName('La Roche-sur-Yon');
        $town3->setPostalCode('85000');
        $town4 = new Town();
        $town4->setName('Saint-Herblain');
        $town4->setPostalCode('44800');
  



        $manager->persist($town1);
        $manager->persist($town2);
        $manager->persist($town3);
        $manager->persist($town4);

        //Campus *********************************************************************************
        $campus1 = new Campus();
        $campus1->setName("Chartres-de-Bretagne");
        $campus2 = new Campus();
        $campus2->setName("Saint-Herblain");
        $campus3 = new Campus();
        $campus3->setName("La Roche-sur-Yon");

        $manager->persist($campus1);
        $manager->persist($campus2);
        $manager->persist($campus3);

        // Spots ********************************************************************************
        $spot1 = new Spot();
        $spot1->setName('Melody Nelson');
        $spot1->setStreet('4 Rue Saint-Thomas');
        $spot1->setLatitude(48.108455);
        $spot1->setLongitude(-1.675147);
        $spot1->setTown($town1);


        $spot2 = new Spot();
        $spot2->setName('Game Over');
        $spot2->setStreet('1 Rue Lebrun');
        $spot2->setLatitude(47.22009);
        $spot2->setLongitude(-1.54947);
        $spot2->setTown($town2);


        $spot3 = new Spot();
        $spot3->setName('Bowl Center');
        $spot3->setStreet('151 Rue du Moulin de la Rousselière');
        $spot3->setLatitude(47.23027);
        $spot3->setLongitude(-1.63857);
        $spot3->setTown($town4);

        $spot4 = new Spot();
        $spot4->setName('Berlin 1989');
        $spot4->setStreet('9 Rue des Piliers de la Chauvinière');
        $spot4->setLatitude(47.23105);
        $spot4->setLongitude(-1.63818);
        $spot4->setTown($town4);


        $spot5 = new Spot();
        $spot5->setName('Le WARP - Taverne Ludique');
        $spot5->setStreet('8 Rue Stéphane Guilleme');
        $spot5->setLatitude(46.66985);
        $spot5->setLongitude(-1.42461);
        $spot5->setTown($town3);


        $spot6 = new Spot();
        $spot6->setName('Calicéo');
        $spot6->setStreet('14 Chemin du Vigneau');
        $spot6->setLatitude(47.21607);
        $spot6->setLongitude(-1.62806);
        $spot6->setTown($town4);


        $spot7 = new Spot();
        $spot7->setName('Escape Game - La Ligue Des Gentlemen');
        $spot7->setStreet('8 Quai Turenne');
        $spot7->setLatitude(47.2127231);
        $spot7->setLongitude(-1.5548051);
        $spot7->setTown($town2);


        $manager->persist($spot1);
        $manager->persist($spot2);
        $manager->persist($spot3);
        $manager->persist($spot4);
        $manager->persist($spot5);
        $manager->persist($spot6);
        $manager->persist($spot7);

        // Users********************************************************************************************
        //la team en admin
        $user1 = new User();
        $user1->setFirstName("Adeline");
        $user1->setName("Avril");
        $user1->setEmailAdress("adelineavril@eni.fr");
        $user1->setActive(true);
        $user1->setAdministrator(true);
        $user1->setPassword($this->encoder->encodePassword($user1, 'adeline'));
        $user1->setPhoneNumber("0645879632");
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setUsername("adeline");
        $user1->setCampus($campus2);
        $user1->setPictureFilename("profile-adeline.jpeg");

        $user2 = new User();
        $user2->setFirstName("Kim");
        $user2->setName("Maroe");
        $user2->setEmailAdress("kimmaroe@eni.fr");
        $user2->setActive(true);
        $user2->setAdministrator(true);
        $user2->setPassword($this->encoder->encodePassword($user2, 'kim'));
        $user2->setPhoneNumber("0758972596");
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setUsername("kim");
        $user2->setCampus($campus2);
        $user2->setPictureFilename("profile-kim.jpeg");

        $user3 = new User();
        $user3->setFirstName("Quentin");
        $user3->setName("Poinsignon");
        $user3->setEmailAdress("quentinpoinsignon@eni.fr");
        $user3->setActive(true);
        $user3->setAdministrator(true);
        $user3->setPassword($this->encoder->encodePassword($user3, 'quentin'));
        $user3->setPhoneNumber("0656243514");
        $user3->setRoles(['ROLE_ADMIN']);
        $user3->setUsername("quentin");
        $user3->setCampus($campus2);
        $user3->setPictureFilename("profile-quentin.jpeg");

        //les users
        $user4 = new User();
        $user4->setFirstName("Guillaume");
        $user4->setName("Sylvestre");
        $user4->setEmailAdress("guillaumesylvestre@eni.fr");
        $user4->setActive(true);
        $user4->setAdministrator(false);
        $user4->setPassword($this->encoder->encodePassword($user4, 'guillaume'));
        $user4->setPhoneNumber("0765897654");
        $user4->setRoles(['ROLE_USER']);
        $user4->setUsername("guillaume");
        $user4->setCampus($campus2);
        $user4->setPictureFilename("profile-guillaume.jpeg");

        $user5 = new User();
        $user5->setFirstName("Hervé");
        $user5->setName("Boisgontier");
        $user5->setEmailAdress("herveboisgontier@eni.fr");
        $user5->setActive(true);
        $user5->setAdministrator(false);
        $user5->setPassword($this->encoder->encodePassword($user5, 'herve'));
        $user5->setPhoneNumber("0676543419");
        $user5->setRoles(['ROLE_USER']);
        $user5->setUsername("hervé");
        $user5->setCampus($campus2);
        $user5->setPictureFilename("profile-hervé.jpeg");

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);

        // State **********************************************************************************************
        $state1 = new State();
        $state2 = new State();
        $state3 = new State();
        $state4 = new State();
        $state5 = new State();
        $state6 = new State();
        $state7 = new State();


        $state1->setLabel("Créée");
        $state2->setLabel("Ouverte");
        $state3->setLabel("Clôturée");
        $state4->setLabel("En cours");
        $state5->setLabel("Terminée");
        $state6->setLabel("Archivée");
        $state7->setLabel("Annulée");

        $manager->persist($state1);
        $manager->persist($state2);
        $manager->persist($state3);
        $manager->persist($state4);
        $manager->persist($state5);
        $manager->persist($state6);
        $manager->persist($state7);

        // Events ******************************************************************************************
        $event1 = new Event();
        $event2 = new Event();
        $event3 = new Event();
        $event4 = new Event();
        $event5 = new Event();
        $event6 = new Event();


        $event1->setName("Soirée Bowling");
        $event2->setName("Beer Afterwork");
        $event3->setName("Apéro fin de projet");
        $event4->setName("Trick or Treat");
        $event5->setName("Après-midi détente - Sauna/Hammam/Piscine");
        $event6->setName("Escape Game");

        $event1->setStartDateTime(new \DateTime("2020-11-16T21:00:00"));
        $event2->setStartDateTime(new \DateTime("2020-10-25T21:00:00"));
        $event3->setStartDateTime(new \DateTime("2020-10-23T19:30:00"));
        $event4->setStartDateTime(new \DateTime("2020-10-31T22:00:00"));
        $event5->setStartDateTime(new \DateTime("2020-07-22T14:00:00"));
        $event6->setStartDateTime(new \DateTime("2020-10-16T20:00:00"));


        $event1->setDuration(60);
        $event2->setDuration(120);
        $event3->setDuration(360);
        $event4->setDuration(240);
        $event5->setDuration(360);
        $event6->setDuration(60);

        $event1->setRegistrationLimitDate(new \DateTime("2020-11-15T21:00:00"));
        $event2->setRegistrationLimitDate(new \DateTime("2020-10-24T21:00:00"));
        $event3->setRegistrationLimitDate(new \DateTime("2020-10-22T19:30:00"));
        $event4->setRegistrationLimitDate(new \DateTime("2020-10-30T22:00:00"));
        $event5->setRegistrationLimitDate(new \DateTime("2020-07-21T14:00:00"));
        $event6->setRegistrationLimitDate(new \DateTime("2020-10-15T20:00:00"));

        $event1->setRegistrationMaxNb(12);
        $event2->setRegistrationMaxNb(20);
        $event3->setRegistrationMaxNb(34);
        $event4->setRegistrationMaxNb(10);
        $event5->setRegistrationMaxNb(20);
        $event6->setRegistrationMaxNb(6);

        $event1->setState($state2);
        $event2->setState($state2);
        $event3->setState($state2);
        $event4->setState($state2);
        $event5->setState($state6);
        $event6->setState($state5);


        $event1->setSpot($spot3);
        $event2->setSpot($spot4);
        $event3->setSpot($spot2);
        $event4->setSpot($spot5);
        $event5->setSpot($spot6);
        $event6->setSpot($spot7);


        $event1->setCampus($campus2);
        $event2->setCampus($campus2);
        $event3->setCampus($campus2);
        $event4->setCampus($campus1);
        $event5->setCampus($campus2);
        $event5->setCampus($campus2);
        $event6->setCampus($campus2);


        $event1->setOwner($user1);
        $event2->setOwner($user2);
        $event3->setOwner($user3);
        $event4->setOwner($user2);
        $event5->setOwner($user3);
        $event6->setOwner($user4);

        $event1->setEventInfos('Fuck it dude, let\'s go bowling');
        $event2->setEventInfos('Boire un petit coup c\'est agréable');
        $event3->setEventInfos('Fêtons ensemble la fin du projet Symfony !');
        $event4->setEventInfos('Well to be honest I don\'t know what this is...');
        $event5->setEventInfos('Comme un poisson dans l\'eau, venez nager et transpirer ensemble...');
        $event6->setEventInfos('Super soirée Escape Game en éspérant que l\'on ne restera pas coincés!!');

        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);
        $manager->persist($event4);
        $manager->persist($event5);
        $manager->persist($event6);

        // Registrations ************************************************************************************
        $registration1 = new Registration();
        $registration2 = new Registration();
        $registration3 = new Registration();
        $registration4 = new Registration();
        $registration5 = new Registration();
        $registration6 = new Registration();
        $registration7 = new Registration();
        $registration8 = new Registration();
        $registration9 = new Registration();

        $registration1->setParticipant($user1);
        $registration2->setParticipant($user2);
        $registration3->setParticipant($user3);
        $registration4->setParticipant($user1);
        $registration5->setParticipant($user2);
        $registration6->setParticipant($user2);
        $registration7->setParticipant($user1);
        $registration8->setParticipant($user3);
        $registration9->setParticipant($user4);


        $registration1->setEvent($event3);
        $registration2->setEvent($event3);
        $registration3->setEvent($event3);
        $registration4->setEvent($event5);
        $registration5->setEvent($event5);
        $registration6->setEvent($event6);
        $registration7->setEvent($event6);
        $registration8->setEvent($event6);
        $registration9->setEvent($event6);

        $registration1->setRegistrationDate(new \DateTime());
        $registration2->setRegistrationDate(new \DateTime());
        $registration3->setRegistrationDate(new \DateTime());
        $registration4->setRegistrationDate(new \DateTime());
        $registration5->setRegistrationDate(new \DateTime());
        $registration6->setRegistrationDate(new \DateTime());
        $registration7->setRegistrationDate(new \DateTime());
        $registration8->setRegistrationDate(new \DateTime());
        $registration9->setRegistrationDate(new \DateTime());

        $manager->persist($registration1);
        $manager->persist($registration2);
        $manager->persist($registration3);
        $manager->persist($registration4);
        $manager->persist($registration5);
        $manager->persist($registration6);
        $manager->persist($registration7);
        $manager->persist($registration8);
        $manager->persist($registration9);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);

        $manager->flush();
    }
}
