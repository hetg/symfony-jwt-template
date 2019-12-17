<?php

namespace App\Mapper;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestMapperInterface.
 */
interface RequestMapperInterface
{
    /**
     * Map all the properties from $request to $toClass. Return a new object.
     *
     * @param Request $request
     * @param string  $toClass
     *
     * @return mixed
     */
    public function map(Request $request, string $toClass);
}
