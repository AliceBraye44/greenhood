<?php

namespace App\Entity;

use App\Repository\CriteriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriteriaRepository::class)]
class Criteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 500)]
    private $data;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $indexReference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $scale;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $coefficient;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private $methodology;

    #[ORM\Column(type: 'string', length: 255)]
    private $pin;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'criterias')]
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getIndexReference(): ?string
    {
        return $this->indexReference;
    }

    public function setIndexReference(?string $indexReference): self
    {
        $this->indexReference = $indexReference;

        return $this;
    }

    public function getScale(): ?string
    {
        return $this->scale;
    }

    public function setScale(?string $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    public function setCoefficient(?int $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getMethodology(): ?string
    {
        return $this->methodology;
    }

    public function setMethodology(?string $methodology): self
    {
        $this->methodology = $methodology;

        return $this;
    }

    public function getPin(): ?string
    {
        return $this->pin;
    }

    public function setPin(string $pin): self
    {
        $this->pin = $pin;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
