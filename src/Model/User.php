<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Enum\UserRole;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use DateTimeInterface;
use Guennichi\ResourceBundle\Attribute\Resource;
use Guennichi\ResourceBundle\Model\ResourceInterface;
use Guennichi\ResourceBundle\Model\TimestampableInterface;
use Guennichi\ResourceBundle\Model\TimestampableTrait;
use Serializable;
use Stringable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Resource(UserRepository::class, UserFactory::class)]
class User implements ResourceInterface, UserInterface, PasswordAuthenticatedUserInterface, TimestampableInterface, Stringable, Serializable
{
    use TimestampableTrait;

    protected ?int $id = null;

    protected ?string $email = null;

    protected ?string $plainPassword = null;

    protected ?string $password = null;

    protected array $roles = [UserRole::DEFAULT];

    protected ?DateTimeInterface $lastLogin = null;

    /**
     * @inheritDoc
     */
    public function serialize(): ?string
    {
        return serialize([
            $this->password,
            $this->email,
            $this->id,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);

        [
            $this->password,
            $this->email,
            $this->id,
        ] = $data;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->roles, true);
    }

    public function addRole(string $role): void
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function removeRole(string $role): void
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
    }

    public function setLastLogin(?DateTimeInterface $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @inheritDoc
     */
    public function getSalt(): void
    {
        // No need to use salt for argon2i algo.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function getUserIdentifier(): string
    {
        return strval($this->email);
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
