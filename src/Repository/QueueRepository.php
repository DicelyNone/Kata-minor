<?php

namespace App\Repository;

use App\Entity\Queue;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Queue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Queue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Queue[]    findAll()
 * @method Queue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Queue::class);
    }

    /**
     * @return Queue[] Returns an array of Queue objects
     */
    public function getTwoWaitingUsers()
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.isWaiting = 1')
            ->orderBy('q.createdAt', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getActiveQueueRowByUser(User $user): ?Queue
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :val')
            ->andWhere('q.isWaiting = 1')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
