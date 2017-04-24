<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

/**
 * Interface HydratorInterface
 * @package Aulinks\Hydrator
 */
interface HydratorInterface
{
    /**
     * @param mixed $data
     * @param $dto $entity
     * @return object
     */
    public function hydrate($data, $dto = null);
}