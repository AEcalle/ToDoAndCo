<?php

declare(strict_types=1);

namespace App\UseCase\User\List;

final class ListQuery
{
    /**
     * @param array<string,string> $criteria
     * @param array<string,string> $orderBy
     */
    public function __construct(
        private array $criteria = [],
        private array $orderBy = [],
        private int $offset = null,
        private int $limit = null)
    {
        $this->criteria = $criteria;
        $this->orderBy = $orderBy;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return array<string,string> $criteria
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * @return array<string,string> $orderBy
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
