<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\UserFactory;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateAction extends AbstractController
{
    public function __construct(private UserFactory $userFactory)
    {
    }
    public function __invoke(User $user): void
    {
        $newUser = $this->userFactory->create(
            $user->getEmail(),
            $user->getPassword(),
            $user->getGivenName(),
            $user->getImage()
        );

        print_r($newUser);
        exit();
    }
}
