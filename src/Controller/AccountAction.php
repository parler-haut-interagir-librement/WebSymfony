<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * The page of the signed-in member: its account and the button that signs it out.
 *
 * @see AccountActionTest
 */
#[IsGranted(User::ROLE_USER)]
final class AccountAction extends AbstractController
{
    #[Route(path: '/account', name: self::class, methods: ['GET'])]
    public function __invoke(#[CurrentUser] User $user): Response
    {
        return $this->render(self::class.'.html.twig', ['user' => $user]);
    }
}
