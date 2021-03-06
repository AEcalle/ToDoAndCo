<?php

declare(strict_types=1);

namespace App\UseCase\Task\Register;

use App\Entity\Task;

final class RegisterCommand
{
    public function __construct(private Task $task)
    {
        $this->task = $task;
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
