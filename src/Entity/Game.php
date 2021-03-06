<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    public const STATUS_PREPARED = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_ENDED = 3;
    public const USERS_NUM = 2;
    public const ROUNDS_NUM = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user1;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user2;

    /**
     * @ORM\OneToMany(targetEntity=Round::class, mappedBy="game")
     * @OrderBy({"orderInGame" = "ASC"})
     */
    private $rounds;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct(array $users)
    {
        $this->rounds = new ArrayCollection();
        $this->user1 = $users[0];
        $this->user2 = $users[1];
        $this->status = $this::STATUS_PREPARED;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1(): ?User
    {
        return $this->user1;
    }

    public function setUser1(User $user1): self
    {
        $this->user1 = $user1;

        return $this;
    }

    public function getUser2(): ?User
    {
        return $this->user2;
    }

    public function setUser2(User $user2): self
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * @return Collection|Round[]
     */
    public function getRounds(): Collection
    {
        return $this->rounds;
    }

    public function addRound(Round $round): self
    {
        if (!$this->rounds->contains($round)) {
            $this->rounds[] = $round;
            $round->setGame($this);
        }

        return $this;
    }

    public function removeRound(Round $round): self
    {
        if ($this->rounds->removeElement($round)) {
            // set the owning side to null (unless already changed)
            if ($round->getGame() === $this) {
                $round->setGame(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
