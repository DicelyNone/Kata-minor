<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getCurrentGame(User $user, int $status): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.user2 = :user')
            ->orWhere('g.user1 = :user')
            ->andWhere('g.status = :status')
            ->setParameter('user', $user)
            ->setParameter('status', $status)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
