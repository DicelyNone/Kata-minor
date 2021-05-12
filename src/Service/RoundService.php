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
        dump($form);
        foreach ($form as $row){
            foreach($row as $square)
            if ($square !== "" && $square !== "0") {
                ++$score;
            }
        }

        return $score;
    }

    public function endRound(int $roundId)
    {
        $round = $this->roundRepository->find($roundId)->setIsActive(false);
        $this->entityManager->persist($round);
        $this->entityManager->flush();
    }

    public function updateFormOfUser(string $user, int $roundId, array $area)
    {
        $round = $this->roundRepository->find($roundId);
        $game = $round->getGame();

        if ($game->getUser1()->getUsername() === $user){
            $round->setFormOfUser1($area);
            $round->setScoreOfUser1($this->getScoreFromForm($area));

        } else {
            $round->setFormOfUser2($area);
            $round->setScoreOfUser2($this->getScoreFromForm($area));
        }

        $this->entityManager->persist($round);
        $this->entityManager->flush();
    }
}