<?php


namespace App\Service;


use App\Entity\Form;
use App\Entity\Game;
use App\Entity\Round;
use App\Repository\FormRepository;
use App\Repository\GameRepository;
use App\Repository\QueueRepository;
use App\Repository\RoundRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    private $entityManager;
    private $gameRepository;
    private $formRepository;
    private $queueRepository;
    private $roundRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                GameRepository $gameRepository,
                                QueueRepository $queueRepository,
                                FormRepository $formRepository,
                                RoundRepository  $roundRepository)
    {
        $this->entityManager = $entityManager;
        $this->gameRepository = $gameRepository;
        $this->queueRepository = $queueRepository;
        $this->formRepository = $formRepository;
        $this->roundRepository = $roundRepository;
    }

    public function initGame(): bool
    {
        $waitingUsers = $this->queueRepository->getTwoWaitingUsers();
        if (count($waitingUsers) < Game::USERS_NUM) {
            dump("not enough users for game");
            return false;
        }
        else {
            foreach ($waitingUsers as $userInQueue) {
                $userInQueue->setIsWaiting(false);
                $users[] = $userInQueue->getUser();
            }

            $game = new Game($users);
            $this->entityManager->persist($game);
            //$this->entityManager->flush();

            $forms = $this->formRepository->findAll();
            for ($i = 0; $i < Game::ROUNDS_NUM; ++$i){
                $form = $forms[rand(0, count($forms)-1)];
                $round = new Round($game, $form, $i);
                $this->entityManager->persist($round);
                $game->addRound($round);
            }

            $this->entityManager->flush();
        }
        return true;
    }

    public function startRound(Game $game) : ?Round
    {
        $rounds = $game->getRounds();
        foreach ($rounds as $round){
            if ($round->getIsActive()){
                return $round;
            }
        }
        return null;
    }

    public function getResult(Game $game): array
    {
        $rounds = $this->roundRepository->findAllByGame($game);
        $user1 = $game->getUser1();
        $user2 = $game->getUser2();

        foreach ($rounds as $round) {
            $result["$user1"][] = $round->getScoreOfUser1();
            $result["$user2"][] = $round->getScoreOfUser2();
        }

        return $result;
    }

    public function getWinner(array $result): string
    {
        $bestScore = 0;
        $winner = '';
        foreach ($result as $user){
            $score = 0;
            foreach ($user as $roundScore){
                $score += $roundScore;
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $winner = key($result);
            } else if ($score === $bestScore) {
                $bestScore = 0;
                $winner = '';
            }
        }
        return $winner;
    }
}