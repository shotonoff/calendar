<?php declare(strict_types = 1);

namespace Aulinks\Repository\Specification;

use Aulinks\Specification\SpecificationInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class LoginSpecification
 * @package Aulinks\Repository\Specification
 */
class LoginSpecification implements SpecificationInterface
{
    /** @var string */
    private $username;

    /**
     * LoginSpecification constructor.
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param QueryBuilder $qb
     * @return bool
     */
    public function isSatisfiedBy($qb): bool
    {
        $qb
            ->andWhere($qb->expr()->eq('u.username', '?1'))->setParameter(1, $this->username)
            ->andWhere($qb->expr()->eq('u.active', '1'))
        ;
        return true;
    }
}