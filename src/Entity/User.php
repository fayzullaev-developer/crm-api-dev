<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
#[UniqueEntity('email', message: "Bu: {{ value }} email allaqachon mavjud.")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email bo\'sh bo\'lmasligi kerak.')]
    #[Assert\Email(message: 'Email formati noto\'g\'ri.')]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Parol bo\'sh bo\'lmasligi kerak.')]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Parol visible bo\'sh bo\'lmasligi kerak.')]
    #[Groups(['user:read', 'user:write'])]
    private ?string $passwordVisible = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ism bo\'sh bo\'lmasligi kerak.')]
    #[Groups(['user:read', 'user:write'])]
    private ?string $givenName = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private ?\DateTimeImmutable $lastActivityAt = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = ["ROLE_USER"];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordVisible(): ?string
    {
        return $this->passwordVisible;
    }

    public function setPasswordVisible(string $passwordVisible): static
    {
        $this->passwordVisible = $passwordVisible;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): static
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getLastActivityAt(): ?\DateTimeImmutable
    {
        return $this->lastActivityAt;
    }

    public function setLastActivityAt(\DateTimeImmutable $lastActivityAt): static
    {
        $this->lastActivityAt = $lastActivityAt;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
