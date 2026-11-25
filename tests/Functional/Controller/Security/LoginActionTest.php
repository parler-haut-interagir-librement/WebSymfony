<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Security;

use App\Controller\AccountAction;
use App\Controller\Security\LoginAction;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Story\AppStory;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversClass(LoginAction::class)]
#[CoversClass(AccountAction::class)]
#[CoversClass(User::class)]
#[CoversClass(UserFactory::class)]
#[CoversClass(AppStory::class)]
final class LoginActionTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    public function testTheLoginPageShowsTheForm(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('form input[name="_username"]');
        self::assertSelectorExists('form input[name="_password"][type="password"]');
        self::assertSelectorExists('form input[name="_csrf_token"]');
        self::assertSelectorTextContains('main h2', 'Sign in');
    }

    public function testAMemberSignsInAndReachesItsAccount(): void
    {
        $client = self::createClient();
        AppStory::load();
        $crawler = $client->request('GET', '/login');
        $client->submit($crawler->selectButton('Sign in')->form(), [
            '_username' => AppStory::MEMBER_USERNAME,
            '_password' => AppStory::MEMBER_PASSWORD,
        ]);

        self::assertResponseRedirects('/account');
        $client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('main', AppStory::MEMBER_USERNAME);
        self::assertSelectorTextContains('main', 'member@example.com');
    }

    public function testAWrongPasswordIsRefused(): void
    {
        $client = self::createClient();
        AppStory::load();
        $crawler = $client->request('GET', '/login');
        $client->submit($crawler->selectButton('Sign in')->form(), [
            '_username' => AppStory::MEMBER_USERNAME,
            '_password' => 'not-the-password',
        ]);

        self::assertResponseRedirects('/login');
        $client->followRedirect();
        self::assertSelectorTextContains('[role="alert"]', 'Invalid credentials.');
        self::assertInputValueSame('_username', AppStory::MEMBER_USERNAME);
    }

    public function testASignedInMemberIsSentToItsAccount(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne(['username' => 'signed-in']));
        $client->request('GET', '/login');

        self::assertResponseRedirects('/account');
    }

    public function testTheMemberSignsOutWithItsCsrfToken(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne(['username' => 'leaving']));

        $crawler = $client->request('GET', '/account');
        self::assertResponseIsSuccessful();

        $client->submit($crawler->selectButton('Sign out')->form());
        self::assertResponseRedirects('/');
        $client->request('GET', '/account');
        self::assertResponseRedirects('/login');
    }

    public function testSigningOutWithoutTheCsrfTokenIsRefused(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne(['username' => 'staying']));
        $client->request('POST', '/logout');

        self::assertResponseStatusCodeSame(403);
        $client->request('GET', '/account');
        self::assertResponseIsSuccessful();
    }
}
