<?php

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoundRepository::class)
 */
class Round
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="rounds")
     */
    private $game;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderInGame;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="first_user_id", referencedColumnName="id")
     */
    private $firstUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="second_user_id", referencedColumnName="id")
     */
    private $secondUser;

    /**
     * @ORM\ManyToOne(targetEntity=Form::class)
     * @ORM\JoinColumn(name="first_user_form_id", referencedColumnName="id")
     */
    private $firstUserForm;

    /**
     * @ORM\ManyToOne(targetEntity=Form::class)
     * @ORM\JoinColumn(name="second_user_form_id", referencedColumnName="id")
     */
    private $secondUserForm;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreOfUser1;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreOfUser2;

    public function __construct(
        Game $game,
        User $firstUser,
        User $secondUser,
        Form $firstUserForm,
        Form $secondUserForm,
        int $order
    ) {
        $this->game = $game;
        $this->firstUser = $firstUser;
        $this->secondUser = $secondUser;
        $this->firstUserForm = $firstUserForm;
        $this->secondUserForm = $secondUserForm;
        $this->orderInGame = $order;
        $this->isActive = true;
        $this->scoreOfUser1 = 0;
        $this->scoreOfUser2 = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstUser(): ?User
    {
        return $this->firstUser;
    }

    public function setFirstUser(User $firstUser): self
    {
        $this->firstUser = $firstUser;

        return $this;
    }

    public function getSecondUser(): ?User
    {
        return $this->secondUser;
    }

    public function setSecondUser(User $secondUser): self
    {
        $this->secondUser = $secondUser;

        return $this;
    }

    public function getFirstUserForm(): ?Form
    {
        return $this->firstUserForm;
    }

    public function setFirstUserForm(Form $firstUserForm): self
    {
        $this->firstUserForm = $firstUserForm;

        return $this;
    }

    public function getSecondUserForm(): ?Form
    {
        return $this->secondUserForm;
    }

    public function setSecondUserForm(Form $secondUserForm): self
    {
        $this->secondUserForm = $secondUserForm;

        return $this;
    }

    public function getGame(): ?game
    {
        return $this->game;
    }

    public function setGame(?game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getOrderInGame(): ?int
    {
        return $this->orderInGame;
    }

    public function setOrderInGame(int $orderInGame): self
    {
        $this->orderInGame = $orderInGame;

        return $this;
    }

    public function getScoreOfUser1(): ?int
    {
        return $this->scoreOfUser1;
    }

    public function setScoreOfUser1(int $scoreOfUser1): self
    {
        $this->scoreOfUser1 = $scoreOfUser1;

        return $this;
    }

    public function getScoreOfUser2(): ?int
    {
        return $this->scoreOfUser2;
    }

    public function setScoreOfUser2(int $scoreOfUser2): self
    {
        $this->scoreOfUser2 = $scoreOfUser2;

        return $this;
    }
}
