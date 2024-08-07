<?php

namespace App\Repository;

use App\Entity\TakePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TakePart>
 *
 * @method TakePart|null find($id, $lockMode = null, $lockVersion = null)
 * @method TakePart|null findOneBy(array $criteria, array $orderBy = null)
 * @method TakePart[]    findAll()
 * @method TakePart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TakePartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TakePart::class);
    }

    //    /**
    //     * @return TakePart[] Returns an array of TakePart objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }


    public function getAllEventByUser($userId)
    {
        return $this->createQueryBuilder('t1')
            ->select('t1', 'e1', 'te')
            ->innerJoin('t1.event', 'e1')
            ->innerJoin('e1.type_event', 'te')
            ->andWhere('t1.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getAllEventIdByUser($userId)
    {
        return $this->createQueryBuilder('t1')
            ->select('e1.id')
            ->innerJoin('t1.event', 'e1')
            ->andWhere('t1.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getAllUserByEvent($eventId)
    {
        return $this->createQueryBuilder('t1')
            ->select('u1.id')
            ->innerJoin('t1.user', 'u1')
            ->andWhere('t1.event = :eventId')
            ->setParameter('eventId', $eventId)
            ->getQuery()
            ->getResult();
    }

}
