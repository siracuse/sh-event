<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Event>
 *
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

    public function paginateEvent(int $page, int $limit, $status): Paginator
    {
        return new Paginator($this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', $status)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->setHint(Paginator::HINT_ENABLE_DISTINCT, false),
//            ->getResult(),
        false
        );
    }

    public function getAllEventByStatus($status): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEventByStatusAndUser($status, $userId)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', $status)
            ->andWhere('e.organiser = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
            ;
    }
}