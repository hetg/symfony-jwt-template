<?php

namespace App\DTO;

/**
 * Class PaginateConditions
 * @package App\DTO
 */
class PaginateConditions
{
    /**
     * @var array
     */
    private $order;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $limit;

    public function __construct(array $order = [], $start, $limit)
    {
        $this->order = $order;
        $this->start = $start;
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
}