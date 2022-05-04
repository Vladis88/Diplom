<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="admin_user")
 */
class AdminUser implements UserInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $lastName = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $siteLink = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $phoneNumber = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $avatar = null;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->firstName && $this->lastName ?
            \sprintf('%s %s', $this->firstName, $this->lastName) : "";
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AdminUser
     */
    public function setId(int $id): AdminUser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return AdminUser
     */
    public function setEmail(?string $email): AdminUser
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return AdminUser
     */
    public function setFirstName(?string $firstName): AdminUser
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return AdminUser
     */
    public function setLastName(?string $lastName): AdminUser
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSiteLink(): ?string
    {
        return $this->siteLink;
    }

    /**
     * @param string|null $siteLink
     * @return AdminUser
     */
    public function setSiteLink(?string $siteLink): AdminUser
    {
        $this->siteLink = $siteLink;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     * @return AdminUser
     */
    public function setPhoneNumber(?string $phoneNumber): AdminUser
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @return AdminUser
     */
    public function setAvatar(?string $avatar): AdminUser
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return AdminUser
     */
    public function setRoles(array $roles): AdminUser
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return AdminUser
     */
    public function setPassword(string $password): AdminUser
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole(string $role): self
    {
        $this->roles[] = $role;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return string
     */
    public function getFullName(): string
    {
        return \sprintf('%s %s', $this->firstName, $this->lastName);
    }

    /**
     *
     * /**
     * @return string
     */
    public function getAvatarVirtual(): string
    {
        $pathItems = explode('/', $this->avatar);

        return \sprintf('%s%s', 'downloads/', \end($pathItems));
    }

    public function getUsername(): string
    {
        return $this->getFirstName();
    }

}
