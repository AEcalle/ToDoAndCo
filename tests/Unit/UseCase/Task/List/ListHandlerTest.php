<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\Task\List;

use App\Repository\TaskRepository;
use App\UseCase\Task\List\ListHandler;
use App\UseCase\Task\List\ListQuery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ListHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $nbTasks = $taskRepository->count([]);
        $listHandler = new ListHandler($taskRepository);

        $tasks = $listHandler->__invoke(new ListQuery());

        self::assertEquals($nbTasks, count($tasks));
    }
}
