<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\AccountAction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * The sign-in page. The firewall reads the form it posts: this action only shows it, with the last user name tried
 * and the error of the last attempt.
 *
 * @see config/packages/security.php
 * @see LoginActionTest
 */
final class LoginAction extends AbstractController
{
    #[Route(path: '/login', name: self::class, methods: ['GET', 'POST'])]
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute(AccountAction::class);
        }

        return $this->render(self::class.'.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}
