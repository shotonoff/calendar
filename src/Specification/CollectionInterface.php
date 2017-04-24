<?php declare(strict_types = 1);

namespace Aulinks\Specification;

/**
 * Interface CollectionInterface
 * @package Aulinks\Specification
 */
interface CollectionInterface
{
    /**
     * @param int $number
     * @return CollectionInterface
     */
    public function skip(int $number): CollectionInterface;

    /**
     * @param int $number
     * @return CollectionInterface
     */
    public function limit(int $number): CollectionInterface;

    /**
     * @return array
     */
    public function asArray(): array;

    /**
     * @return object
     */
    public function first();
}