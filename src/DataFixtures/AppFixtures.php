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
        $user = new User();
        $user->setEmail('anonyme@email.com');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'password'
        ));
        $user->setUsername('anonyme');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();

        for ($j = 0; $j < 3; ++$j) {
            $task = new Task();
            $task->setTitle('Tâche'.$j);
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->setContent('Contenu'.$j);
            $task->setAuthor($user);
            $manager->persist($task);
            $manager->flush();
        }

        for ($i = 0; $i < 10; ++$i) {
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

            for ($j = 0; $j < mt_rand(0, 5); ++$j) {
                $task = new Task();
                $task->setTitle('Tâche'.$j);
                $task->setCreatedAt(new \DateTimeImmutable());
                $task->setContent('Contenu'.$j);
                $task->setAuthor($user);
                $manager->persist($task);
                $manager->flush();
            }
        }
    }
}
