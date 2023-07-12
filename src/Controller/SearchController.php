<?php

namespace App\Controller;

use App\Form\SearchFlightType;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FlightRepository $flightRepository,
        private AirportRepository $airportRepository
    ) {
    }

    #[Route('/search', name: 'search_bar')]
    public function search(
        Request $request,
    ): Response {
        $searchForm = $this->createForm(SearchFlightType::class);
        $searchForm->handleRequest($request);

        //homepage search bar
        $departure = $request->query->get("departure_airport");
        $arrival = $request->query->get("arrival_airport");
        $departure_datetime = $request->query->get("departure_datetime");


        if ($departure !== null || $arrival !== null) {
            $defaults = ["departure_airport" => $departure, "arrival_airport" => $arrival];
            $departure = $this->airportRepository->findOneBy(["id" => $departure]);
            $arrival = $this->airportRepository->findOneBy(["id" => $arrival]);
        } else {
            $defaults = ["departure_airport" => "", "arrival_airport" => ""];
        }

        //mini-carte homepage
        $code = $request->query->get("code");
        if ($code) {
            $arrival = $this->airportRepository->findOneBy(["code" => $code]);
            $defaults = ["departure_airport" => "", "arrival_airport" => $arrival->getId()];
        }

        //search bar
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $departure = $searchForm->get('departure_airport')->getData();
            $arrival = $searchForm->get('arrival_airport')->getData();
            $departure_datetime = $searchForm->get('departure_datetime')->getData();
        }

        $flights = $this->flightRepository->search($departure, $arrival, $departure_datetime);

        return $this->render('search/searchBar.html.twig', [
            'searchForm' => $searchForm->createView(),
            'flights' => $flights,
            'defaults' => $defaults
        ]);
    }

    #[Route('/flight-details', name: 'app_flight_details')]
    public function flightDetails($id): Response
    {
        $selectedFlight = $this->flightRepository->find($id);
        if (!$selectedFlight) {
            throw $this->createNotFoundException('Flight not found');
        }
        return $this->render('search/flightDetails.html.twig', [
            'flight' => $selectedFlight,
        ]);
    }
}
