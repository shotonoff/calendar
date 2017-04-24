<?php declare(strict_types = 1);

namespace Aulinks\Specification;

/**
 * Interface SpecificationInterface
 * @package Aulinks\Specification
 */
interface SpecificationInterface
{
    /**
     * @param object $object
     * @return bool
     */
    public function isSatisfiedBy($object): bool;
}