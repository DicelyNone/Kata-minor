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
            ->getOneOrNullResult();
    }

    public function findLastFinishedGame(User $user): ?Game
    {
        $queryBuilder = $this->createQueryBuilder('g');

        $queryBuilder
            ->orWhere(
                $queryBuilder->expr()->eq('g.user1', ':user'),
                $queryBuilder->expr()->eq('g.user2', ':user')
            )
            ->andWhere(
                $queryBuilder->expr()->eq('g.status', ':status')
            )
            ->setParameter('user', $user)
            ->setParameter('status', Game::STATUS_ENDED)
            ->addOrderBy('g.id', 'DESC')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
