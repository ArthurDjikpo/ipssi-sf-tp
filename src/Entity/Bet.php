<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BetRepository")
 */
class Bet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $playerName;

    /**
     * @ORM\Column(type="integer")
     */
    private $betCase;

    /**
     * @ORM\Column(type="string")
     */
    private $colorCase;

    /**
     * @ORM\Column(type="integer")
     */
    private $money;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerName(): ?string
    {
        return $this->playerName;
    }

    public function setPlayerName(string $playerName): self
    {
        $this->playerName = $playerName;

        return $this;
    }

    public function getBetCase(): ?int
    {
        return $this->betCase;
    }

    public function setBetCase(int $betCase): self
    {
        $this->betCase = $betCase;

        return $this;
    }

    public function getColorCase(): ?string
    {
        return $this->colorCase;
    }

    public function setColorCase(string $colorCase): self
    {
        $this->colorCase = $colorCase;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }
}
