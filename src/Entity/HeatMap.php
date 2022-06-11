<?php

namespace App\Entity;

use App\Repository\HeatMapRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;


#[ORM\Entity(repositoryClass: HeatMapRepository::class)]
class HeatMap
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    private $coordX;

    #[ORM\Column(type: 'float', nullable: true)]
    private $coordY;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $notation;

    #[ORM\Column(type: 'array', nullable: true)]
    private $keyData;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $UpdatedAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $ref;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoordX(): ?float
    {
        return $this->coordX;
    }

    public function setCoordX(float $coordX): self
    {
        $this->coordX = $coordX;

        return $this;
    }

    public function getCoordY(): ?float
    {
        return $this->coordY;
    }

    public function setCoordY(float $coordY): self
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

    public function getKeyData(): ?array
    {
        return $this->keyData;
    }

    public function setKeyData(?array $keyData): self
    {
        $this->keyData = $keyData;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTime $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }
}
