<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\User\List;

use App\Repository\UserRepository;
use App\UseCase\User\List\ListHandler;
use App\UseCase\User\List\ListQuery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ListHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $redisCache = static::getContainer()->get(TagAwareCacheInterface::class);
        $nbUsers = $userRepository->count([]);
        $listHandler = new ListHandler($userRepository,$redisCache);

        $users = $listHandler->__invoke(new ListQuery());

        self::assertEquals($nbUsers, count($users));
    }
}
