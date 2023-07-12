<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
#[ORM\Table("flight")]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, name: "number")]
    private ?string $number = null;

    #[ORM\Column(length: 255, name: "airline")]
    private ?string $airline = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: "departure_datetime")]
    private ?\DateTimeInterface $departure_datetime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: "arrival_datetime")]
    private ?\DateTimeInterface $arrival_datetime = null;

    #[ORM\ManyToOne(inversedBy: 'flights')]
    #[ORM\JoinColumn(name: "departure_airport")]
    private ?Airport $departure_airport = null;

    #[ORM\ManyToOne(inversedBy: 'flights')]
    #[ORM\JoinColumn(name: "arrival_airport")]
    private ?Airport $arrival_airport = null;
    
    #[ORM\Column(type: Types::INTEGER, name: "price")]
    private ?int $price = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "plane_id")]
    private ?Plane $plane_id = null;

    #[ORM\OneToMany(mappedBy: 'flight_id', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
    public function getPrice(): ?int
    {
        return $this->price;
    }
    
    public function setPrice(?int $price): self
    {
        $this->price = $price;
        return $this;
    }
    public function getAirline(): ?string
    {
        return $this->airline;
    }

    public function setAirline(string $airline): self
    {
        $this->airline = $airline;

        return $this;
    }

    public function getDepartureDatetime(): ?\DateTimeInterface
    {
        return $this->departure_datetime;
    }

    public function setDepartureDatetime(\DateTimeInterface $departure_datetime): self
    {
        $this->departure_datetime = $departure_datetime;

        return $this;
    }

    public function getArrivalDatetime(): ?\DateTimeInterface
    {
        return $this->arrival_datetime;
    }

    public function setArrivalDatetime(\DateTimeInterface $arrival_datetime): self
    {
        $this->arrival_datetime = $arrival_datetime;

        return $this;
    }

    public function getDepartureAirport(): ?Airport
    {
        return $this->departure_airport;
    }

    public function setDepartureAirport(?Airport $departure_airport): self
    {
        $this->departure_airport = $departure_airport;

        return $this;
    }

    public function getArrivalAirport(): ?Airport
    {
        return $this->arrival_airport;
    }

    public function setArrivalAirport(?Airport $arrival_airport): self
    {
        $this->arrival_airport = $arrival_airport;

        return $this;
    }

    public function getPlaneId(): ?Plane
    {
        return $this->plane_id;
    }

    public function setPlaneId(?Plane $plane_id): self
    {
        $this->plane_id = $plane_id;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setFlightId($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getFlightId() === $this) {
                $booking->setFlightId(null);
            }
        }

        return $this;
    }
}
