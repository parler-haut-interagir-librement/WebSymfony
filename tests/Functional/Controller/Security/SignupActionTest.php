<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Security;

use App\Controller\AccountAction;
use App\Controller\Security\SignupAction;
use App\Dto\Form\Type\SignupFormDto;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\Type\SignupForm;
use App\Repository\UserRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversClass(SignupAction::class)]
#[CoversClass(SignupForm::class)]
#[CoversClass(SignupFormDto::class)]
#[CoversClass(AccountAction::class)]
#[CoversClass(User::class)]
#[CoversClass(UserFactory::class)]
final class SignupActionTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private const string PASSWORD = 'a-long-enough-password';

    public function testTheSignupPageShowsTheFormUnderTheNamesOfTheSymfonyForm(): void
    {
        $client = self::createClient();
        $client->request('GET', '/signup');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('input[name="signup[username]"]');
        self::assertSelectorExists('input[name="signup[email]"][type="email"]');
        self::assertSelectorExists('input[name="signup[plainPassword][first]"][minlength="12"]');
        self::assertSelectorExists('input[name="signup[plainPassword][second]"]');
        self::assertSelectorExists('input[name="signup[_token]"]');
        self::assertSelectorTextContains('#signup_plainPassword_first_help', 'At least 12 characters.');
    }

    public function testAValidSignupCreatesTheAccountAndSignsItIn(): void
    {
        $client = self::createClient();
        $this->submit($client, 'newcomer', 'Newcomer@Example.com', self::PASSWORD, self::PASSWORD);

        self::assertResponseRedirects('/account');
        $client->followRedirect();
        self::assertSelectorTextContains('main', 'newcomer');

        $user = self::getContainer()->get(UserRepository::class)->findOneBy(['username' => 'newcomer']);
        self::assertInstanceOf(User::class, $user);
        self::assertSame('newcomer@example.com', $user->getEmail());
        self::assertSame([User::ROLE_USER], $user->getRoles());
        self::assertNotSame(self::PASSWORD, $user->getPassword());
        self::assertTrue(self::getContainer()->get(UserPasswordHasherInterface::class)->isPasswordValid($user, self::PASSWORD));
    }

    public function testATakenUserNameOrEmailIsRefused(): void
    {
        $client = self::createClient();
        UserFactory::createOne(['username' => 'taken', 'email' => 'taken@example.com']);
        $this->submit($client, 'taken', ' Taken@Example.COM ', self::PASSWORD, self::PASSWORD);

        self::assertResponseIsUnprocessable();
        self::assertSelectorTextContains('form', 'This user name is already taken.');
        self::assertSelectorTextContains('form', 'An account already uses this email address.');
        self::assertInputValueSame('signup[username]', 'taken');
        self::assertSame(1, self::getContainer()->get(UserRepository::class)->count());
    }

    public function testAShortOrRepeatedWrongPasswordAndABadUserNameAreRefused(): void
    {
        $client = self::createClient();
        $this->submit($client, 'no spaces', 'not-an-email', 'short', 'short');

        self::assertResponseIsUnprocessable();
        self::assertSelectorTextContains('form', 'A user name holds only letters');
        self::assertSelectorExists('#signup_email[aria-invalid="true"]');
        self::assertSelectorExists('#signup_plainPassword_first[aria-invalid="true"]');
        self::assertSelectorNotExists('input[name="signup[plainPassword][first]"][value]');

        $this->submit($client, 'someone', 'someone@example.com', self::PASSWORD, self::PASSWORD.'!');
        self::assertResponseIsUnprocessable();
        self::assertSelectorTextContains('form', 'The two passwords are not the same.');
        self::assertSame(0, self::getContainer()->get(UserRepository::class)->count());
    }

    public function testASignedInMemberIsSentToItsAccount(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne());
        $client->request('GET', '/signup');

        self::assertResponseRedirects('/account');
    }

    private function submit(KernelBrowser $client, string $username, string $email, string $password, string $confirmation): void
    {
        $crawler = $client->request('GET', '/signup');
        $client->submit($crawler->selectButton('Create my account')->form(), [
            'signup[username]' => $username,
            'signup[email]' => $email,
            'signup[plainPassword][first]' => $password,
            'signup[plainPassword][second]' => $confirmation,
        ]);
    }
}
