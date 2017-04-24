<?php declare(strict_types = 1);

namespace Aulinks\Specification;

/**
 * Interface Specificable
 * @package Aulinks\Specification
 */
interface Specificable
{
    /**
     * @param SpecificationInterface $specification
     * @return CollectionInterface
     */
    public function getBySpecification(SpecificationInterface $specification): CollectionInterface;
}