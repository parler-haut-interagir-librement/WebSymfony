<?php

declare(strict_types=1);

namespace App\Story;

use App\Entity\User;
use App\Factory\UserFactory;
use Override;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

/**
 * The data of the dev environment: an administrator, a member, and ten more members. The two named accounts sign in
 * with the passwords below, written in the README; never load these fixtures where the site is public.
 *
 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#stories
 */
#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public const string ADMIN_USERNAME = 'admin';

    public const string ADMIN_PASSWORD = 'admin-password';

    public const string MEMBER_USERNAME = 'member';

    public const string MEMBER_PASSWORD = 'member-password';

    #[Override]
    public function build(): void
    {
        UserFactory::createOne([
            'username' => self::ADMIN_USERNAME,
            'email' => 'admin@example.com',
            'password' => self::ADMIN_PASSWORD,
            'roles' => [User::ROLE_ADMIN],
        ]);
        UserFactory::createOne([
            'username' => self::MEMBER_USERNAME,
            'email' => 'member@example.com',
            'password' => self::MEMBER_PASSWORD,
        ]);
        UserFactory::createMany(10);
    }
}
