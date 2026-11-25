<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\UserCrudController;
use App\Entity\User;
use App\Factory\UserFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversClass(DashboardController::class)]
#[CoversClass(UserCrudController::class)]
#[CoversClass(User::class)]
#[CoversClass(UserFactory::class)]
final class DashboardControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    public function testAnAnonymousVisitorIsSentToTheLoginPage(): void
    {
        $client = self::createClient();
        $client->request('GET', '/admin');

        self::assertResponseRedirects('/login');
    }

    public function testAMemberIsForbidden(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne());
        $client->request('GET', '/admin');

        self::assertResponseStatusCodeSame(403);
    }

    public function testAnAdministratorSeesTheDashboard(): void
    {
        $client = self::createClient();
        $client->loginUser(UserFactory::createOne(['roles' => [User::ROLE_ADMIN]]));
        $client->request('GET', '/admin');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Administration');
        self::assertSelectorTextContains('.main-sidebar, nav', 'Users');
    }

    public function testAnAdministratorListsAndShowsTheUsersButNeitherCreatesNorEditsThem(): void
    {
        $client = self::createClient();
        $admin = UserFactory::createOne(['username' => 'boss', 'roles' => [User::ROLE_ADMIN]]);
        $member = UserFactory::createOne(['username' => 'member-in-list', 'email' => 'listed@example.com']);
        $client->loginUser($admin);

        $client->request('GET', '/admin/user');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('table', 'member-in-list');
        self::assertSelectorTextContains('table', 'listed@example.com');

        $client->request('GET', '/admin/user/'.$member->getId());
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('body', 'member-in-list');

        $client->request('GET', '/admin/user/new');
        self::assertResponseStatusCodeSame(403);
        $client->request('GET', '/admin/user/'.$member->getId().'/edit');
        self::assertResponseStatusCodeSame(403);
    }
}
