<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Round;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RoundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Round::class);
    }

    public function findAllByGame(Game $game): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.game = :val')
            ->setParameter('val', $game)
            ->orderBy('r.orderInGame', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
