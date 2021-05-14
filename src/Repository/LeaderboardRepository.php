<?php

namespace App\Repository;

use App\Entity\Leaderboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LeaderboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leaderboard::class);
    }

    public function findLeaders(int $numOfLeaders): array
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.result', 'DESC')
            ->setMaxResults($numOfLeaders)
            ->getQuery()
            ->getResult();
    }
}
