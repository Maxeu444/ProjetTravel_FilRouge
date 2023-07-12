<?php

namespace App\Entity;

use App\Repository\PlaneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaneRepository::class)]
#[ORM\Table(name: "plane")]
class Plane
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(length: 255, name: "model")]
    private ?string $model = null;

    #[ORM\Column(name: "isAvailable")]
    private ?bool $isAvailable = null;

    #[ORM\ManyToOne(inversedBy: 'planes')]
    #[ORM\JoinColumn(name: "airport_id")]
    private ?Airport $air_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getAirId(): ?Airport
    {
        return $this->air_id;
    }

    public function setAirId(?Airport $air_id): self
    {
        $this->air_id = $air_id;

        return $this;
    }
}
