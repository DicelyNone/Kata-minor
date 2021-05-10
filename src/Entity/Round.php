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
     * @ORM\Column(type="array")
     */
    private $formOfUser1 = [];

    /**
     * @ORM\Column(type="array")
     */
    private $formOfUser2 = [];

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
     * @ORM\ManyToOne(targetEntity=Form::class)
     */
    private $form;

    public function __construct(Game $game, Form $form, int $order)
    {
        $this->game = $game;
        $this->form = $form;
        $this->formOfUser1 = $form->getArea();
        $this->formOfUser2 = $form->getArea();
        $this->orderInGame = $order;
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormOfUser1(): ?array
    {
        return $this->formOfUser1;
    }

    public function setFormOfUser1(array $formOfUser1): self
    {
        $this->formOfUser1 = $formOfUser1;

        return $this;
    }

    public function getFormOfUser2(): ?array
    {
        return $this->formOfUser2;
    }

    public function setFormOfUser2(array $formOfUser2): self
    {
        $this->formOfUser2 = $formOfUser2;

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

    public function getForm(): ?form
    {
        return $this->form;
    }

    public function setForm(?form $form): self
    {
        $this->form = $form;

        return $this;
    }
}
