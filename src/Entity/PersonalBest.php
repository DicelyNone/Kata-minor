<?php

namespace App\Entity;

use App\Repository\PersonalBestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonalBestRepository::class)
 */
class PersonalBest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numOfWins;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bestScore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumOfWins(): ?int
    {
        return $this->numOfWins;
    }

    public function setNumOfWins(?int $numOfWins): self
    {
        $this->numOfWins = $numOfWins;

        return $this;
    }

    public function getBestScore(): ?int
    {
        return $this->bestScore;
    }

    public function setBestScore(?int $bestScore): self
    {
        $this->bestScore = $bestScore;

        return $this;
    }
}
