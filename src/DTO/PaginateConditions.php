<?php

namespace App\DTO;

/**
 * Class PaginateConditions
 * @package App\DTO
 */
class PaginateConditions
{

    private array $order;

    private int $start;

    private int $limit;

    public function __construct(int $start, int $limit, array $order = [])
    {
        $this->order = $order;
        $this->start = $start;
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}