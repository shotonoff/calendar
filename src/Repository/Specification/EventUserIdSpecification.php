<?php declare(strict_types = 1);

namespace Aulinks\Repository\Specification;

use Aulinks\Specification\SpecificationInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class UserIdSpecification
 * @package Aulinks\Repository\Specification
 */
class EventUserIdSpecification implements SpecificationInterface
{
    /** @var int */
    private $id;

    /**
     * UserIdSpecification constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param QueryBuilder $qb
     * @return bool
     */
    public function isSatisfiedBy($qb): bool
    {
        $qb
            ->andWhere($qb->expr()->eq('e.user', ':userId'))->setParameter('userId', $this->id);
        return true;
    }
}