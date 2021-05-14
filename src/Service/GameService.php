<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\PersonalBest;
use App\Entity\Round;
use App\Entity\User;
use App\Repository\FormRepository;
use App\Repository\GameRepository;
use App\Repository\QueueRepository;
use App\Repository\RoundRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    private $entityManager;

    private $gameRepository;

    private $formRepository;

    private $queueRepository;

    private $roundRepository;

    private $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        GameRepository $gameRepository,
        QueueRepository $queueRepository,
        FormRepository $formRepository,
        RoundRepository $roundRepository,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->gameRepository = $gameRepository;
        $this->queueRepository = $queueRepository;
        $this->formRepository = $formRepository;
        $this->roundRepository = $roundRepository;
        $this->userRepository = $userRepository;
    }

    public function finishPreviousGames(User $user)
    {
        $games = $this->gameRepository->findAllUnfinishedGames($user);
        foreach ($games as $game) {
            $game->setStatus(Game::STATUS_ENDED);
            $this->entityManager->persist($game);
        }
        $this->entityManager->flush();
    }

    public function initGame(): bool
    {
        $waitingUsers = $this->queueRepository->getTwoWaitingUsers();

        if (count($waitingUsers) < Game::USERS_NUM) {
            dump("not enough users for game");

            return false;
        }

        $users = [];

        foreach ($waitingUsers as $userInQueue) {
            $userInQueue->setIsWaiting(false);

            $users[] = $userInQueue->getUser();
        }

        $game = new Game($users);
        $this->entityManager->persist($game);

        $forms = $this->formRepository->findAll();

        for ($i = 0; $i < Game::ROUNDS_NUM; ++$i) {
            $firstUserForm = $forms[rand(0, count($forms) - 1)];
            $secondUserForm = $forms[rand(0, count($forms) - 1)];

            $round = new Round($game, $users[0], $users[1], $firstUserForm, $secondUserForm, $i);

            $this->entityManager->persist($round);

            $game->addRound($round);
        }

        $game->setStatus(Game::STATUS_PREPARED);

        $this->entityManager->flush();

        return true;
    }

    public function startRound(Game $game): ?Round
    {
        $rounds = $game->getRounds();

        foreach ($rounds as $round) {
            if ($round->getIsActive()) {
                return $round;
            }
        }

        $this->endGame($game);

        return null;
    }

    public function getLastFinishedGame(User $user): ?Game
    {
        return $this->gameRepository->findLastFinishedGame($user);
    }

    public function updatePersonalBestScore(User $user, array $result)
    {
        $personalBest = $user->getPersonalBest();
        $gameScore = 0;
        foreach ($result as $score){
            $gameScore += $score;
        }
        if ($personalBest->getBestScore() < $gameScore){
            $personalBest->setBestScore($gameScore);
            $this->entityManager->persist($personalBest);
            $this->entityManager->flush();
        }

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

        $this->updatePersonalBestScore($user1, $result["$user1"]);
        $this->updatePersonalBestScore($user2, $result["$user2"]);

        return $result;
    }

    public function getWinner(array $result): string
    {
        $bestScore = 0;
        $winner = '';

        foreach ($result as $user => $scores) {
            $score = 0;

            foreach ($scores as $roundScore) {
                $score += $roundScore;
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $winner = $user;
            } elseif ($score === $bestScore) {
                $bestScore = 0;
                $winner = '';
            }
        }

        $user = $this->userRepository->findByUsername($winner);
        $personalBest = $user->getPersonalBest();
        $personalBest->setNumOfWins($personalBest->getNumOfWins()+1);
        $this->entityManager->persist($personalBest);
        $this->entityManager->flush();

        return $winner;
    }

    public function endGame(Game $game): void
    {
        $game->setStatus(GAME::STATUS_ENDED);

        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }
}