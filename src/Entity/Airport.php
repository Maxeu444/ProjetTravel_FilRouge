<?php

namespace App\Entity;

use App\Repository\AirportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
#[ORM\Table(name: "airport")]
class Airport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, name: "code")]
    private ?string $code = null;

    #[ORM\Column(length: 255, name: "name")]
    private ?string $name = null;

    #[ORM\Column(length: 255, name: "city")]
    private ?string $city = null;

    #[ORM\Column(length: 255, name: "country")]
    private ?string $country = null;

    #[ORM\Column(name: "gate_count")]
    private ?int $gate_count = null;

    #[ORM\OneToMany(mappedBy: 'air_id', targetEntity: Plane::class)]
    private Collection $planes;

    #[ORM\OneToMany(mappedBy: 'departure_airport', targetEntity: Flight::class)]
    private Collection $flights;

    public function __construct()
    {
        $this->planes = new ArrayCollection();
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getGateCount(): ?int
    {
        return $this->gate_count;
    }

    public function setGateCount(int $gate_count): self
    {
        $this->gate_count = $gate_count;

        return $this;
    }

    /**
     * @return Collection<int, Plane>
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    public function addPlane(Plane $plane): self
    {
        if (!$this->planes->contains($plane)) {
            $this->planes->add($plane);
            $plane->setAirId($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->planes->removeElement($plane)) {
            // set the owning side to null (unless already changed)
            if ($plane->getAirId() === $this) {
                $plane->setAirId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
            $flight->setDepartureAirport($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->removeElement($flight)) {
            // set the owning side to null (unless already changed)
            if ($flight->getDepartureAirport() === $this) {
                $flight->setDepartureAirport(null);
            }
        }

        return $this;
    }
}
