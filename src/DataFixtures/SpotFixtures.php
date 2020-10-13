<?php

namespace App\DataFixtures;

use App\Entity\Spot;
use App\Entity\Town;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SpotFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $spot1 = new Spot();
        $spot1->setName('Melody Nelson');
        $spot1->setStreet('4 Rue Saint-Thomas');
        $spot1->setLatitude(48.108455);
        $spot1->setLongitude(-1.675147);
        $town1 = new Town();
        $town1->setName('Rennes');
        $town1->setPostalCode('35000');
        $spot1->setTown($town1);

        $manager->persist($spot1);

        $spot2 = new Spot();
        $spot2->setName('Gameover');
        $spot2->setStreet('1 Rue Lebrun');
        $spot2->setLatitude(47.220173);
        $spot2->setLongitude(-1.548964);
        $town2 = new Town();
        $town2->setName('Nantes');
        $town2->setPostalCode('44000');
        $spot2->setTown($town2);
        $manager->persist($spot2);

        $spot3 = new Spot();
        $spot3->setName('L\'instant Jeux');
        $spot3->setStreet('19 rue Georges Clémenceau');
        $spot3->setLatitude(46.977119);
        $spot3->setLongitude(-1.313038);
        $town3 = new Town();
        $town3->setName('Montaigu');
        $town3->setPostalCode('85600');
        $spot3->setTown($town3);
        $manager->persist($spot3);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['spot'];
    }
}
