<?php

namespace App\Repository;

use App\Entity\TakePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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


//SELECT *
//FROM `take_part` AS t1
//INNER JOIN `event` ON t1.event_id = event.id
//WHERE t1.user_id = 5


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
}
