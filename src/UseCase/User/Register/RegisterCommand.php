<?php

declare(strict_types=1);

namespace App\UseCase\User\Register;

use App\Entity\User;

final class RegisterCommand
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
