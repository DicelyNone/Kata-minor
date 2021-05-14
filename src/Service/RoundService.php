<?php

namespace App\Service;

use App\Entity\Form;
use App\Entity\Round;
use App\Entity\User;
use App\Repository\RoundRepository;
use Doctrine\ORM\EntityManagerInterface;

class RoundService
{
    private $roundRepository;

    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        RoundRepository $roundRepository
    ) {
        $this->entityManager = $entityManager;
        $this->roundRepository = $roundRepository;
    }

    public function getStatus(int $roundId): bool
    {
        $round = $this->roundRepository->find($roundId);

        return $round->getIsActive();
    }

    public function getScoreFromForm(array $form): int
    {
        $score = 0;

        foreach ($form as $row) {
            foreach ($row as $square) {
                if ($square !== "" && $square !== "0") {
                    ++$score;
                }
            }
        }

        return $score;
    }

    public function endRound(int $roundId): void
    {
        $round = $this->roundRepository->find($roundId)->setIsActive(false);

        $this->entityManager->persist($round);
        $this->entityManager->flush();
    }

    public function updateFormOfUser(string $user, int $roundId, array $area): void
    {
        $round = $this->roundRepository->find($roundId);
        $game = $round->getGame();

        if ($game->getUser1()->getUsername() === $user) {
            $round->setScoreOfUser1($this->getScoreFromForm($area));
        } else {
            $round->setScoreOfUser2($this->getScoreFromForm($area));
        }

        $this->entityManager->persist($round);
        $this->entityManager->flush();
    }

    public function getFormInRoundByUser(Round $round, User $user): Form
    {
        if ($round->getFirstUser() === $user) {
            $form = $round->getFirstUserForm();
        } else {
            $form = $round->getSecondUserForm();
        }

        return $form;
    }
}