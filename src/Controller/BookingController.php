<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\FlightRepository;
use App\Repository\PlaneRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private FlightRepository $flightRepository,
        private PlaneRepository $planeRepository,
        private BookingRepository $bookingRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/booking/{flight_id}', name: 'app_booking')]
    public function index($flight_id): Response
    {
        $user = $this->getUser();
        $flight = $this->flightRepository->find($flight_id);

        return $this->render('booking/booking.html.twig', [
            'user' => $user,
            'flight' => $flight,
        ]);
    }

    #[Route('/booking/{flight_id}/confirm', name: 'app_addBooking')]
    public function addBooking(
        int $flight_id,
    ) {
        $newBooking = new Booking();
        $flight = $this->flightRepository->findOneBy(["id" => $flight_id]);
        $newBooking->setFlightId($flight);
        $user = $this->userRepository->findOneBy(["username" => $this->getUser()->getUserIdentifier()]);
        $newBooking->setAccountId($user);

        $flight = $this->flightRepository->findOneBy(["id" => $flight]);
        $planeId = $flight->getPlaneId();
        $plane = $this->planeRepository->findOneBy(["id" => $planeId]);
        $plane_capacity = $plane->getCapacity();


        if ($this->remainingSeats($planeId) >= 1) {
            $seatNumber = $this->bookingRepository->calculateSeatNumber($plane_capacity, $flight);
            $newBooking->setSeatNumber($seatNumber);
            $this->entityManager->persist($newBooking);
            $this->entityManager->flush();
            return $this->render('booking/confirmation.html.twig', [
                'user' => $user,
            ]);
        } else {
            return new Response("Plus de places disponibles");
            //carte en "complet"
        }
    }

    public function remainingSeats($planeId)
    {
        $plane = $this->planeRepository->findOneBy(["id" => $planeId]);
        $capacity = $plane->getCapacity();
        $seatsTaken = $this->bookingRepository->findBy(["flight_id" => $this->flightRepository->findOneBy(["plane_id" => $plane])]);
        return $capacity - count($seatsTaken);
    }
}
