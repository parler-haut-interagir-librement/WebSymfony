<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping\Column;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(User::class)]
final class UserTest extends TestCase
{
    public function testUserEntity(): void
    {
        $user = new User('', '', '');

        self::assertNull($user->getId());
        self::assertTrue($user->isNew());
        $normalizedEmail = 'test@example.com';
        self::assertSame($normalizedEmail, $user->setEmail('test@example.com')->getEmail());
        self::assertSame($normalizedEmail, $user->setEmail('Test@Example.CoM  ')->getEmail());
        self::assertSame($normalizedEmail, $user->setEmail('   Test@Example.CoM')->getEmail());
        self::assertSame($normalizedEmail, $user->setEmail('Test@example.CoM')->getEmail());
        self::assertSame('COil', $user->setUsername('COil')->getUsername());
        self::assertSame('COil', $user->getUserIdentifier());
        self::assertSame('123456', $user->setPassword('123456')->getPassword());
        self::assertSame('COil (not persisted)', (string) $user);
        self::assertSame(['ROLE_USER'], $user->getRoles());
    }

    public function testDatesAreSetByTheConstructor(): void
    {
        $before = time();
        $user = new User('email', 'password', 'username');
        self::assertGreaterThanOrEqual($before, $user->getCreatedAt()->getTimestamp());
        self::assertSame($user->getCreatedAt()->getTimestamp(), $user->getUpdatedAt()->getTimestamp());
    }

    public function testRolesAlwaysHoldRoleUserOnce(): void
    {
        $user = new User('email', 'password', 'username');
        self::assertSame([User::ROLE_USER], $user->getRoles());

        $user->setRoles([User::ROLE_ADMIN, User::ROLE_USER, User::ROLE_ADMIN]);
        self::assertSame([User::ROLE_USER, User::ROLE_ADMIN], $user->getRoles());

        $user->setRoles([User::ROLE_USER, 'ROLE_EDITOR', User::ROLE_ADMIN]);
        self::assertSame([User::ROLE_USER, 'ROLE_EDITOR', User::ROLE_ADMIN], $user->getRoles());

        $user->setRoles([]);
        self::assertSame([User::ROLE_USER], $user->getRoles());
    }

    public function testStoredRolesNeverHoldRoleUserNorDuplicates(): void
    {
        $user = new User('email', 'password', 'username');
        $user->setRoles([User::ROLE_ADMIN, User::ROLE_USER, User::ROLE_ADMIN, 'ROLE_EDITOR']);

        self::assertSame([0 => User::ROLE_ADMIN, 1 => 'ROLE_EDITOR'], $this->storedRoles($user));
    }

    public function testRolesReadFromTheDatabaseAreListedOnceWithoutGaps(): void
    {
        $user = new User('email', 'password', 'username');
        new ReflectionClass(User::class)->getProperty('roles')->setValue($user, [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_ADMIN]);

        self::assertSame([User::ROLE_USER, User::ROLE_ADMIN], $user->getRoles());
    }

    /**
     * @return array<mixed, mixed>
     */
    private function storedRoles(User $user): array
    {
        $roles = new ReflectionClass(User::class)->getProperty('roles')->getValue($user);
        self::assertIsArray($roles);

        return $roles;
    }

    public function testUserGetUserIdentifier(): void
    {
        $user = new User('email', 'password', 'username');
        $user->setUsername('');
        $this->expectException(LogicException::class);
        $user->getUserIdentifier();
    }

    public function testUserSerialize(): void
    {
        $user = new User('email', 'password', 'serialized');
        // The session keeps the crc32c of the hashed password, never the hashed password itself.
        $serializedUser = \sprintf('O:15:"App\Entity\User":4:{i:0;N;i:1;s:10:"serialized";i:2;s:8:"%s";i:3;s:5:"email";}', hash('crc32c', 'password'));
        self::assertSame($serializedUser, serialize($user));
        self::assertStringNotContainsString('"password"', serialize($user));
    }

    public function testUserUnserialize(): void
    {
        $user = new User('other-email', 'other-password', 'other');
        $user->__unserialize([null, 'serialized', 'password', 'email']);
        self::assertNull($user->getId());
        self::assertSame('serialized', $user->getUsername());
        self::assertSame('password', $user->getPassword());
        self::assertSame('email', $user->getEmail());
    }

    public function testPersistedUserIsPrintedWithItsId(): void
    {
        $user = new User('email', 'password', 'username');
        new ReflectionClass(User::class)->getProperty('id')->setValue($user, 7);

        self::assertSame('username (7)', (string) $user);
    }

    public function testColumnsOfTheConstructorAreMappedAsDeclared(): void
    {
        $columns = [];
        foreach (['email', 'password', 'username'] as $name) {
            $attributes = new ReflectionClass(User::class)->getProperty($name)->getAttributes(Column::class);
            self::assertCount(1, $attributes, $name);
            $columns[$name] = $attributes[0]->newInstance();
        }

        self::assertSame(['email', 'password', 'username'], array_keys($columns));
        foreach ($columns as $name => $column) {
            self::assertSame(255, $column->length, $name);
            self::assertFalse($column->nullable, $name);
        }

        self::assertTrue($columns['email']->unique);
        self::assertFalse($columns['password']->unique);
        self::assertTrue($columns['username']->unique);
    }
}
