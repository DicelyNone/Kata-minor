<?php


namespace App\Service;


use App\Entity\Round;
use App\Entity\User;
use App\Repository\FormRepository;
use App\Repository\GameRepository;
use App\Repository\QueueRepository;
use App\Repository\RoundRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class RoundService
{
    private $gameRepository;
    private $formRepository;
    private $roundRepository;
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager,
                                GameRepository $gameRepository,
                                FormRepository $formRepository,
                                RoundRepository  $roundRepository,
                                Security $security)
    {
        $this->entityManager = $entityManager;
        $this->gameRepository = $gameRepository;
        $this->formRepository = $formRepository;
        $this->roundRepository = $roundRepository;
        $this->security = $security;
    }

    public function getStatus(int $roundId): bool
    {
        $round = $this->roundRepository->find($roundId);
        return $round->getIsActive();
    }

    public function getScoreFromForm(array $form): int
    {
        $score = 0;
        foreach ($form as $square){
            if ($square === null || $square === 0) {
                ++$score;
            }
        }

        return $score;
    }

    public function getResult(Round $round): array
    {


        $result['user1'] = $round->getScoreOfUser1();
        $result['user2'] = $round->getScoreOfUser2();

        return $result;
    }

    public function endRound(int $roundId)
    {
        $round = $this->roundRepository->find($roundId)->setIsActive(false);
        $this->entityManager->persist($round);
        $this->entityManager->flush();
    }
}