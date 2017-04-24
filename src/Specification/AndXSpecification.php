<?php declare(strict_types = 1);

namespace Aulinks\Specification;

/**
 * Class AndXSpecification
 * @package Aulinks\Specification
 */
class AndXSpecification implements SpecificationInterface
{
    /** @var array */
    private $specifications;

    /**
     * AndXSpecification constructor.
     * @param array $specifications
     */
    public function __construct(...$specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * @param SpecificationInterface $spec
     * @return SpecificationInterface
     */
    public function and(SpecificationInterface $spec): SpecificationInterface
    {
        $this->specifications[] = $spec;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($object): bool
    {
        foreach ($this->specifications as $spec) {
            if (!$spec->isSatisfiedBy($object)) {
                return false;
            }
        }
        return true;
    }
}