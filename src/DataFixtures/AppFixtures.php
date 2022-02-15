<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $task = new Task();
            $task->setTitle('Tâche'.$i);
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->setContent('Contenu'.$i);
            $manager->persist($task);
            $manager->flush();
        }

        for ($i = 0; $i < 5; ++$i) {
            $user = new User();
            $user->setEmail('email'.$i.'@email.com');
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'password'
            ));
            $user->setUsername('username'.$i);
            $user->setRoles(0 === $i % 2 ? ['ROLE_ADMIN'] : ['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();
        }
    }
}
