<?php

declare(strict_types=1);

namespace App\UseCase\Task\Register;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RegisterHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(RegisterCommand $command): void
    {
        $task = $command->getTask();

        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
