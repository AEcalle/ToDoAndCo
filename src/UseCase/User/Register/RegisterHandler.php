<?php

declare(strict_types=1);

namespace App\UseCase\User\Register;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class RegisterHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function __invoke(RegisterCommand $command): void
    {
        $user = $command->getUser();

        $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
