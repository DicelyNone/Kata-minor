<?php

namespace App\Repository;

use App\Entity\Queue;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Queue::class);
    }

    public function getTwoWaitingUsers(): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.isWaiting = true')
            ->orderBy('q.createdAt', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult();
    }

    public function getActiveQueueRowByUser(User $user): ?Queue
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :val')
            ->andWhere('q.isWaiting = true')
            ->setParameter('val', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
