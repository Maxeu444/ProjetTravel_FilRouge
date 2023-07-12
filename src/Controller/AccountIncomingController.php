<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FlightRepository;



class AccountIncomingController extends AbstractController
{
    public function __construct(private FlightRepository $flightRepository)
    {
    }
    #[Route("/account/incomingFlights", name: "incoming_flights")]
    public function incoming(): Response
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();
        $flights = $this->flightRepository->findUpcomingFlightsByUser($user);

        return $this->render('accountPage/accountIncoming.html.twig', [
            'flights' => $flights,
            'user' => $user
        ]);
    }

    #[Route("account/historyFlights", name: "history_flights")]
    public function history()
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();
        $flights = $this->flightRepository->findHistoryFlightsByUser($user);

        return $this->render('accountPage/accountIncoming.html.twig', [
            'flights' => $flights,
            'user' => $user
        ]);
    }
}
