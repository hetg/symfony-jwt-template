<?php

namespace App\Mapper;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\DeserializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class RequestMapper.
 */
class RequestMapper implements RequestMapperInterface
{
    /**
     * @var ArrayTransformerInterface
     */
    private $_serializer;

    /**
     * RequestMapper constructor.
     *
     * @param ArrayTransformerInterface $serializer
     */
    public function __construct(ArrayTransformerInterface $serializer)
    {
        $this->_serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Request $request, string $toClass)
    {
        $data = $this->_extractData($request);

        $context = DeserializationContext::create()->setGroups(['Default']);

        try {
            $dto = $this->_serializer->fromArray($data, $toClass, $context);
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }

        return $dto;
    }

    /**
     * Return an array of data from request.
     *
     * @param Request $request
     *
     * @return array
     */
    private function _extractData(Request $request)
    {
        $method = $request->getMethod();

        if ('GET' === $method) {
            $data = $request->query->all();
        } else {
            $params = $request->request->all();
            $files = $request->files->all();

            if (is_array($params) && is_array($files)) {
                $data = array_replace_recursive($params, $files);
            } else {
                $data = $params ?: $files;
            }
        }

        return $data;
    }
}
