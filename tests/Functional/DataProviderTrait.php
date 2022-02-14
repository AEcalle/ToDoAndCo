<?php

declare(strict_types=1);

namespace App\Tests\Functional;

trait DataProviderTrait
{
    /**
     * @return array<int, array<int, string>> $items
     */
    public function tasksUri(): array
    {
        return [
            ['/tasks'],
            ['/tasks/create'],
            ['/tasks/1/edit'],
            ['/tasks/1/toggle'],
            ['/tasks/1/delete'],
        ];
    }

    /**
     * @return array<int, array<int, string>> $items
     */
    public function usersUri(): array
    {
        return [
            ['/users'],
            ['/users/create'],
            ['/users/1/edit'],
        ];
    }
}
