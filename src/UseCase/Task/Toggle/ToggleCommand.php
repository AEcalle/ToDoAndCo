<?php

declare(strict_types=1);

namespace App\UseCase\Task\Toggle;

use App\Entity\Task;

final class ToggleCommand
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
