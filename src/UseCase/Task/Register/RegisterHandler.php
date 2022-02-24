<?php

declare(strict_types=1);

namespace App\UseCase\Task\Register;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Security;

#[AsMessageHandler]
final class RegisterHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function __invoke(RegisterCommand $command): void
    {
        $task = $command->getTask();

        if (null === $task->getId()) {
            /* @phpstan-ignore-next-line */
            $task->setAuthor($this->security->getUser());
        }

        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
