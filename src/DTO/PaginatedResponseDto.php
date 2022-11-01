<?php

namespace App\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * Class PaginatedResponseDto.
 */
class PaginatedResponseDto
{
    /**
     * @JMS\Type("integer")
     */
    public int $recordsTotal;

    /**
     * @JMS\Type("integer")
     */
    public int $recordsFiltered;

    /**
     * @JMS\Type("array")
     */
    public array $data = [];
}
