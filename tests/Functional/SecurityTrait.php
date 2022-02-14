<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait SecurityTrait
{
    public function RedirectIfNotLogged(string $uri): void
    {
        $client = static::createClient();
        $client->request('GET', $uri);

        self::assertResponseRedirects('http://localhost/login');
    }
    /**
     * @param array<int, string> $roles
     */
    public function getUserByRoles(string $role = 'ROLE_ADMIN'): User
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        return $userRepository->findOneByRole($role);
    }

    public function login(User $testUser): KernelBrowser
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        return $client->loginUser($testUser);
    }

}
