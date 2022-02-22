<?php

declare(strict_types=1);

namespace App\UseCase\User\Register;

use App\Entity\User;

final class RegisterCommand
{
    public function __construct(private User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
