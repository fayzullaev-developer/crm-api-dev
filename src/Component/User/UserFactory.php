<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\MediaObject;
use App\Entity\User;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(
        string $email,
        string $password,
        string $givenName,
        MediaObject $image,
    ): User
    {
        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setPasswordVisible($password);
        $user->setGivenName($givenName);
        $user->setLastActivityAt(new DatePoint(timezone: new DateTimeZone('Asia/Tashkent')));
        $user->setImage($image);

        return $user;
    }
}
