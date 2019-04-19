<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CaseRouletteRepository")
 */
class CaseRoulette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="array")
     */
    private $color = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getColor(): ?array
    {
        return $this->color;
    }

    public function setColor(array $color): self
    {
        $this->color = $color;

        return $this;
    }
}
