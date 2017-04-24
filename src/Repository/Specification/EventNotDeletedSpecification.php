<?php declare(strict_types = 1);

namespace Aulinks\Repository\Specification;

use Aulinks\Specification\SpecificationInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class EventNotDeletedSpecification
 * @package Aulinks\Repository\Specification
 */
class EventNotDeletedSpecification implements SpecificationInterface
{
    /**
     * @param QueryBuilder $qb
     * @return bool
     */
    public function isSatisfiedBy($qb): bool
    {
        $qb
            ->andWhere($qb->expr()->eq('e.deleted', ':deleted'))->setParameter('deleted', false);
        return true;
    }
}