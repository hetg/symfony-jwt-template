<?php

namespace App\ArgumentResolver;

use App\DTO\PaginateConditions;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class PaginateConditionsResolver.
 */
class PaginateConditionsResolver implements ArgumentValueResolverInterface
{
    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if (null === $argument->getType()) {
            return false;
        }

        if (PaginateConditions::class === $argument->getType()) {
            return true;
        }

        return false;
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $order = $request->get('order');
        $start = $request->get('start');
        $limit = $request->get('length');

        if (null === $limit) {
            $limit = $request->get('limit');
        }

        if (!isset($order)) {
            $column = $request->get('sort_by');
            $dir = $request->get('sort_direction');

            $order[] = [
                'column' => null !== $column && '' !== $column ? $column : 'id',
                'dir' => null !== $dir && '' !== $dir ? $dir : 'DESC',
            ];
        }

        $start = is_numeric($start) ? intval($start) : 0;
        $limit = is_numeric($limit) ? intval($limit) : 100;

        $dto = new PaginateConditions($order, $start, $limit);

        yield $dto;
    }
}
