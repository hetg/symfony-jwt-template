<?php

namespace App\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * Class PaginatedResponseDto.
 */
class PaginatedResponseDto
{
    /**
     * @var int
     *
     * @JMS\Type("integer")
     */
    public $recordsTotal;

    /**
     * @var int
     *
     * @JMS\Type("integer")
     */
    public $recordsFiltered;

    /**
     * @var array
     *
     * @JMS\Type("array")
     */
    public $data = [];
}
