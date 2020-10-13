<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $state1 = new State();
        $state2 = new State();
        $state3 = new State();
        $state4 = new State();

        $state1->setLabel("Crée");
        $state2->setLabel("Ouverte");
        $state3->setLabel("Activité en cours");
        $state4->setLabel("Ouverte");

        $manager->persist($state1);
        $manager->persist($state2);
        $manager->persist($state3);
        $manager->persist($state4);

        $manager->flush();
    }
}
