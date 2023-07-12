<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\Table(name: "booking")]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @[ORM\Column(type=Types::DATETIME_MUTABLE, name="date", options={"default"="CURRENT_TIMESTAMP"})]
     */
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(name: "seat_number")]
    private ?int $seat_number = null;

    #[ORM\JoinColumn(name: "flight_id")]
    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Flight $flight_id = null;

    #[ORM\JoinColumn(name: "user_id")]
    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $account_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?int
    {
        if ($this->flight_id) {
            return $this->flight_id->getPrice();
        }
        return null;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seat_number;
    }

    public function setSeatNumber(int $seat_number): self
    {
        $this->seat_number = $seat_number;

        return $this;
    }

    public function getFlightId(): ?Flight
    {
        return $this->flight_id;
    }

    public function setFlightId(?Flight $flight_id): self
    {
        $this->flight_id = $flight_id;

        return $this;
    }

    public function getAccountId(): ?User
    {
        return $this->account_id;
    }

    public function setAccountId(?User $account_id): self
    {
        $this->account_id = $account_id;

        return $this;
    }
}
