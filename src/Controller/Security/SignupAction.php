<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Controller\AccountAction;
use App\Dto\Form\Type\SignupFormDto;
use App\Entity\User;
use App\Form\Type\SignupForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The sign-up page: a valid form creates the account, with its password hashed, and signs it in.
 *
 * @see SignupActionTest
 */
final class SignupAction extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly Security $security,
    ) {
    }

    #[Route(path: '/signup', name: self::class, methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute(AccountAction::class);
        }

        $dto = new SignupFormDto();
        $form = $this->createForm(SignupForm::class, $dto)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User((string) $dto->email, '', (string) $dto->username);
            $user->setEmail((string) $dto->email);
            $user->setPassword($this->passwordHasher->hashPassword($user, (string) $dto->plainPassword));
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $response = $this->security->login($user, 'form_login', 'main');

            return $response ?? $this->redirectToRoute(AccountAction::class);
        }

        return $this->render(self::class.'.html.twig', [
            'form' => $form,
            'password_min_length' => SignupFormDto::PASSWORD_MIN_LENGTH,
        ]);
    }
}
