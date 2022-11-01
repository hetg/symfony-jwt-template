<?php

namespace App\Mapper;

use App\Exception\ValidationException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DTOMapper.
 */
class DTOMapper
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Map data from public properties from object $from to object $to.
     *
     * @param mixed $from
     * @param mixed $to
     * @param bool $mapNullValues if false, the null values from the object $from should not be mapped
     * @param bool $validate If true. Object $to will be validated after mapping
     * @param array|null $groups The validation groups to validate. If none is given, "Default" is assumed
     *
     * @return mixed
     */
    public function map($from, $to, bool $mapNullValues = false, bool $validate = true, array $groups = null)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $publicVars = get_object_vars($from);

        foreach ($publicVars as $key => $value) {
            if (!$mapNullValues && null === $value) {
                continue;
            }

            if (is_array($value) || is_object($value)) {
                continue;
            }

            if ($propertyAccessor->isWritable($to, $key)) {
                $propertyAccessor->setValue($to, $key, $value);
            }
        }

        if ($validate) {
            $errors = $this->validator->validate($to, null, $groups);

            if (count($errors) > 0) {
                throw new ValidationException('Validation Failed', $errors);
            }
        }

        return $to;
    }
}
