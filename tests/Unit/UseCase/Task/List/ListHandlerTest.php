<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\Task\List;

use App\Repository\TaskRepository;
use App\UseCase\Task\List\ListHandler;
use App\UseCase\Task\List\ListQuery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ListHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $redisCache = static::getContainer()->get(TagAwareCacheInterface::class);
        $nbTasks = $taskRepository->count([]);
        $listHandler = new ListHandler($taskRepository, $redisCache);

        $tasks = $listHandler->__invoke(new ListQuery());

        self::assertEquals($nbTasks, count($tasks));
    }
}
