<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Override;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * Users with a hashed password: the plain one is given as "password", and hashed after instantiation.
 *
 * @extends PersistentObjectFactory<User>
 *
 * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories
 */
final class UserFactory extends PersistentObjectFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    #[Override]
    public static function class(): string
    {
        return User::class;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    protected function defaults(): array
    {
        return [
            'email' => self::faker()->unique()->email(),
            'username' => self::faker()->unique()->userName(),
            'password' => self::faker()->password(12),
        ];
    }

    #[Override]
    protected function initialize(): static
    {
        return $this->afterInstantiate(function (User $user): void {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        });
    }
}
