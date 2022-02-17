<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\User\List;

use App\Repository\UserRepository;
use App\UseCase\User\List\ListHandler;
use App\UseCase\User\List\ListQuery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ListHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $nbUsers = $userRepository->count([]);
        $listHandler = new ListHandler($userRepository);

        $users = $listHandler->__invoke(new ListQuery());

        self::assertEquals($nbUsers, count($users));
    }
}
