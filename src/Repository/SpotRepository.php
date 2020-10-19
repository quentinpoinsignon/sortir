<?php

namespace App\Repository;

use App\Entity\Spot;
use App\Entity\Campus;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function MongoDB\BSON\fromJSON;

/**
 * @method Spot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spot[]    findAll()
 * @method Spot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spot::class);
    }

    public function spotTest(int $idcampus)
    {
        return $this->createQueryBuilder('s')
            ->join('s.town', 't')
            ->join('s.events', 'e')
            ->join('e.campus', 'c')
            ->where('c.id = :val')
            ->setParameter('val', $idcampus)
            ->addSelect('t.name')
            ->addSelect('t.postalCode')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Spot[] Returns an array of Spot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Spot
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
