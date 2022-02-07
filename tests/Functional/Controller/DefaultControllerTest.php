<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DefaultControllerTest extends WebTestCase
{
    use \App\Tests\Functional\SecurityTrait;

    public function testRedirectIfNotLogged(): void
    {
        $this->RedirectIfNotLogged('/');
    }

    public function testHomePage(): void
    {
        $client = $this->login($this->getUserByRoles());
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }
}
