<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $campus1 = new Campus();
        $campus1->setName("Chartres de Bretagne");
        $manager->persist($campus1);
        $campus2 = new Campus();
        $campus2->setName("Saint Herblain");
        $manager->persist($campus2);
        $campus3 = new Campus();
        $campus3->setName("La Roche sur Yon");
        $manager->persist($campus3);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['campus'];
    }
}
