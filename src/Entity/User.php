<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LogicException;
use Override;
use Stringable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function Symfony\Component\String\u;

/**
 * An account of the application: it signs in with its user name and its hashed password. Its dates are set by the
 * Timestampable extension of stof/doctrine-extensions-bundle.
 *
 * @see https://github.com/symfony/demo/blob/main/src/Entity/User.php
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
final class User implements Stringable, UserInterface, PasswordAuthenticatedUserInterface
{
    public const string ROLE_USER = 'ROLE_USER';

    public const string ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, unique: true, nullable: false)]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    #[Gedmo\Timestampable(on: 'create')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    #[Gedmo\Timestampable(on: 'update')]
    private DateTimeImmutable $updatedAt;

    /**
     * The roles granted besides ROLE_USER, which every account has.
     *
     * @var list<string>
     */
    #[ORM\Column(type: Types::JSON, nullable: false)]
    private array $roles = [];

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
        private string $email,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $password,
        #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
        private string $username,
    ) {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isNew(): bool
    {
        return null === $this->id;
    }

    #[Override]
    public function __toString(): string
    {
        return \sprintf('%s (%s)', $this->getUserIdentifier(), (string) ($this->id ?? 'not persisted'));
    }

    /**
     * The user as the session keeps it: the hashed password is hashed once more with crc32c, so the session never holds
     * it, and a changed password still signs the other sessions out.
     *
     * @return array{int|null, string, string, string}
     */
    public function __serialize(): array
    {
        return [$this->id, $this->username, hash('crc32c', $this->password), $this->email];
    }

    /**
     * @param array{int|null, string, string, string} $data
     */
    public function __unserialize(array $data): void
    {
        [$this->id, $this->username, $this->password, $this->email] = $data;
    }

    #[Override]
    public function getUserIdentifier(): string
    {
        if ('' === $this->username) {
            throw new LogicException('User username cannot be empty.');
        }

        return $this->username;
    }

    /**
     * Returns the roles granted to the user: ROLE_USER, then the others, each once.
     *
     * @return list<string>
     */
    #[Override]
    public function getRoles(): array
    {
        return array_values(array_unique([self::ROLE_USER, ...$this->roles]));
    }

    /**
     * @param list<string> $roles the roles besides ROLE_USER
     */
    public function setRoles(array $roles): self
    {
        $this->roles = array_values(array_diff(array_unique($roles), [self::ROLE_USER]));

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Be careful with your users' emails, they should be normalized.
     */
    public function setEmail(string $email): self
    {
        $this->email = u($email)->trim()->lower()->toString();

        return $this;
    }

    #[Override]
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
