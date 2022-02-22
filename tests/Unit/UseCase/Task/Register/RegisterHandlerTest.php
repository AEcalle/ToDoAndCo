<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\Task\Register;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\UseCase\Task\Register\RegisterCommand;
use App\UseCase\Task\Register\RegisterHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegisterHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $nbTasks = $taskRepository->count([]);
        $task = new Task();
        $task->setContent('content');
        $task->setTitle('title');
        $registerHandler = new RegisterHandler($entityManager);

        $registerHandler->__invoke(new RegisterCommand($task));

        self::assertEquals($nbTasks + 1, $taskRepository->count([]));

        $task->setContent('ModifiedContent');
        $registerHandler->__invoke(new RegisterCommand($task));

        self::assertEquals('ModifiedContent', $taskRepository->find($task->getId())->getContent());
    }
}
