<?php

namespace App\Controller;

use App\Form\SearchFlightType;
use App\Repository\AirportRepository;
use App\Repository\FlightRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HomepageController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private FlightRepository $flightRepository,
        private AirportRepository $airportRepository
    ) {
    }

    #[Route('/homepageTest', name: 'app_homepage')]
    public function homepage(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Vous devez vous connecter pour accéder à cette page');
        }
        $username = $this->getUser()->getUserIdentifier();
        return new Response("Bienvenue " . $username);
    }

    #[Route('/homepage', name: 'homepage')]
    public function searchTwo(Request $request)
    {
        $searchForm = $this->createForm(SearchFlightType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $departure = $searchForm->get('departure_airport')->getData();
            $arrival = $searchForm->get('arrival_airport')->getData();
            $departure_datetime = $searchForm->get('departure_datetime')->getData();

            $searchCriteria = [];
            if ($departure !== null) {
                $searchCriteria["departure_airport"] = $departure->getId();
            }
            if ($arrival !== null) {
                $searchCriteria["arrival_airport"] = $arrival->getId();
            }
            if ($departure_datetime !== null) {
                $formatted_departure_datetime = $departure_datetime->format('Y-m-d');
                $searchCriteria["departure_datetime"] = $formatted_departure_datetime;
            }
            $queryString = http_build_query($searchCriteria);

            return $this->redirect("/search?" . $queryString);
        }

        $departure = $searchForm->get('departure_airport')->getData();
        $arrival = $searchForm->get('arrival_airport')->getData();
        $departure_datetime = $searchForm->get('departure_datetime')->getData();

        $flights = $this->flightRepository->search($departure, $arrival, $departure_datetime);

        return $this->render('homepage/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'flights' => $flights,
        ]);
    }
}
