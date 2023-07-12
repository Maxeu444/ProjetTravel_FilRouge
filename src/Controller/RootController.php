<?php 

// src/Controller/RootController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RootController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route(path: '/', name: 'root')]
    public function index(): Response
    {
        // Vérifier si l'utilisateur est connecté
        $user = $this->security->getUser();

        // Si l'utilisateur est connecté, rediriger vers la page d'accueil
        if ($user) {
            return $this->redirectToRoute('homepage');
        }

        // Sinon, rediriger vers la page de connexion
        return $this->redirectToRoute('app_login');
    }
}
