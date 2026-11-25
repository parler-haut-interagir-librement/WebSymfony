<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Controller\AccountAction;
use App\Entity\User;
use App\Factory\UserFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversClass(AccountAction::class)]
#[CoversClass(User::class)]
#[CoversClass(UserFactory::class)]
final class AccountActionTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    public function testAnAnonymousVisitorIsSentToTheLoginPage(): void
    {
        $client = self::createClient();
        $client->request('GET', '/account');

        self::assertResponseRedirects('/login');
    }

    public function testTheMemberSeesItsAccountAndItsRoles(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne(['username' => 'ada', 'email' => 'ada@example.com', 'roles' => [User::ROLE_ADMIN]]));
        $client->request('GET', '/account');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('main h2', 'My account');
        self::assertSelectorTextContains('main', 'Welcome, ada.');
        self::assertSelectorTextContains('main', 'ada@example.com');
        self::assertSelectorCount(2, 'main kbd.role');
        self::assertSelectorExists('header a[href="/admin"]');
    }

    public function testAMemberWithoutTheAdminRoleHasNoLinkToTheAdministration(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne());
        $client->request('GET', '/account');

        self::assertResponseIsSuccessful();
        self::assertSelectorNotExists('header a[href="/admin"]');
    }
}
