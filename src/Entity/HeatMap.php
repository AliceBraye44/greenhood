<?php

namespace App\Entity;

use App\Repository\HeatMapRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GridRepository::class)]
class HeatMap
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $coordX;

    #[ORM\Column(type: 'integer')]
    private $coordY;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $notation;

    #[ORM\Column(type: 'object', nullable: true)]
    private $keyData;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $UpdatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoordX(): ?int
    {
        return $this->coordX;
    }

    public function setCoordX(int $coordX): self
    {
        $this->CoordX = $coordX;

        return $this;
    }

    public function getCoordY(): ?int
    {
        return $this->coordY;
    }

    public function setCoordY(int $coordY): self
    {
        $this->coordY = $coordY;

        return $this;
    }

    public function getNotation(): ?int
    {
        return $this->notation;
    }

    public function setNotation(?int $notation): self
    {
        $this->notation = $notation;

        return $this;
    }

    public function getKeyData(): ?object
    {
        return $this->keyData;
    }

    public function setKeyData(?object $keyData): self
    {
        $this->keyData = $keyData;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }
}
