<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $user = new User();
         $user->setFirstName("toto");
         $user->setName("gargamel");
         $user->setEmailAdress("toto.gargamel@mail.fr");
         $user->setActive(true);
         $user->setAdministrator(false);
         $user->setPassword("F6KIj89H650");
         $user->setPhoneNumber("0645879632");
         $user->setRoles(['ROLE_USER']);
         $user->setUsername("totolembrouille");
         $manager->persist($user);

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
        $manager->persist($user2);

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
        $manager->persist($user3);
        $manager->flush();
    }
}
