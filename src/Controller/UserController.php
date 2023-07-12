<?php

namespace App\Controller;

use App\Form\AccountUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route("/account/delete", name: "account_delete")]
    public function accountDelete(
        UserRepository $repo,
        Request $request
    ) {
        $user = $this->getUser();
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException('Vous devez être connecté pour accéder à cette page');
        }
        $username = $this->getUser()->getUserIdentifier();
        $user = $repo->findOneBy(['username' => $username]);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        $request->getSession()->invalidate();
        $this->container->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute("app_login");
    }

    #[Route(path: '/account', name: 'account')]
    public function accountInfo(Request $request): Response
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();

        $updateForm = $this->createForm(AccountUpdateType::class, $user);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès!');
            return $this->redirectToRoute('account_info');
        }

        return $this->render('accountPage/account.html.twig', [
            'form' => $updateForm->createView(),
            'user' => $user,
        ]);
    }

    #[Route(path: '/account/info', name: 'account_info_partial')]
public function accountInfoPartial(Request $request): Response
{
    // Récupérer l'utilisateur actuellement connecté
    $user = $this->getUser();

    $updateForm = $this->createForm(AccountUpdateType::class, $user);
    $updateForm->handleRequest($request);

    if ($updateForm->isSubmitted() && $updateForm->isValid()) {
        $this->entityManager->flush();
        $this->addFlash('success', 'Vos informations ont été mises à jour avec succès!');
        return $this->redirectToRoute('account_info_partial');
    }

    return $this->render('accountPage/accountInfo.html.twig', [
        'form' => $updateForm->createView(),
        'user' => $user,
    ]);
}
}
