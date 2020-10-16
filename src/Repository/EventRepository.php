<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


    /**
     * @param $user
     * @return array  tableau d'évenements dont le $user est l'organisateur
     */
    public function findByOwner($user) {
        return $this->createQueryBuilder('e')
            ->andWhere('e.owner = :val')
            ->setParameter('val', $user)
            ->orderBy('e.startDateTime')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $user
     * @return int|mixed|string tableau d'évenements dont le user est participant
     */
    public function findEventByRegistrationsByIdUser($user) {
        return $this->createQueryBuilder('e')
            ->select('r', 'e')
            ->from('Event', 'e')
            ->join('r.participant', 'p')
            ->addSelect('p')
            ->andWhere('p = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult();
    }


//en sql SELECT e, r FROM Event inner join Registration on e.id = r.eventId WHERE r.participant = e.owner

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */

//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
