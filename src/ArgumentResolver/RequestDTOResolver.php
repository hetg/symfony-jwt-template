<?php

namespace App\ArgumentResolver;

use App\DTO\Interfaces\RequestDTOInterface;
use App\DTO\Interfaces\ValidatedDTOInterface;
use App\Exception\ValidationException;
use App\Mapper\RequestMapperInterface;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestDTOResolver.
 */
class RequestDTOResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    private RequestMapperInterface $mapper;

    private bool $validate = false;

    public function __construct(ValidatorInterface $validator, RequestMapperInterface $mapper)
    {
        $this->validator = $validator;
        $this->mapper = $mapper;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (null === $argument->getType() || !class_exists($argument->getType())) {
            return false;
        }

        $classImplements = class_implements($argument->getType());

        if (in_array(ValidatedDTOInterface::class, $classImplements)) {
            $this->validate = true;
        }

        if (in_array(RequestDTOInterface::class, $classImplements)) {
            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $class = $argument->getType();

        $dto = $this->mapper->map($request, $class);

        if ($this->validate) {
            $errors = $this->validator->validate($dto);

            if (count($errors) > 0) {
                throw new ValidationException('Validation Failed', $errors);
            }
        }

        yield $dto;
    }
}
