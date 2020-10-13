<?php

namespace App\DataFixtures;

use App\Entity\Town;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TownFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $town1 = new Town();
        $town1->setName('Rennes');
        $town1->setPostalCode('35000');
        $manager->persist($town1);
        $town2 = new Town();
        $town2->setName('Nantes');
        $town2->setPostalCode('44000');
        $manager->persist($town2);
        $town3 = new Town();
        $town3->setName('Montaigu');
        $town3->setPostalCode('85600');
        $manager->persist($town3);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['town'];
    }
}
