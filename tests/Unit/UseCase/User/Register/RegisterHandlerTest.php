<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\User\Register;

use App\Entity\User;
use App\Repository\UserRepository;
use App\UseCase\User\Register\RegisterCommand;
use App\UseCase\User\Register\RegisterHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $userRepository = static::getContainer()->get(UserRepository::class);
        $nbUsers = $userRepository->count([]);
        $user = new User();
        $user->setEmail('email@email.com');
        $user->setPassword($passwordHasher->hashPassword(
                $user,
                'password'
            ));
        $user->setUsername('username');
        $user->setRoles(['ROLE_ADMIN']);
        $registerHandler = new RegisterHandler($entityManager, $passwordHasher);

        $registerHandler->__invoke(new RegisterCommand($user));

        self::assertEquals($nbUsers + 1, $userRepository->count([]));

        $user->setEmail('ModifiedEmail@email.com');
        $registerHandler->__invoke(new RegisterCommand($user));

        self::assertEquals('ModifiedEmail@email.com', $userRepository->find($user->getId())->getEmail());
    }
}
