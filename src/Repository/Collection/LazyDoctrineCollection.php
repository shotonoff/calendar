<?php declare(strict_types = 1);

namespace Aulinks\Repository\Collection;

use Doctrine\ORM\QueryBuilder;
use Aulinks\Specification\CollectionInterface;

/**
 * Class LazyDoctrineCollection
 * @package Aulinks\Entity\Collection
 */
class LazyDoctrineCollection implements CollectionInterface
{
    /** @var QueryBuilder */
    private $qb;

    /**
     * LazyDoctrineCollection constructor.
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function skip(int $number): CollectionInterface
    {
        $this->qb->setFirstResult($number);
    }

    /**
     * {@inheritdoc}
     */
    public function limit(int $number): CollectionInterface
    {
        $this->qb->setMaxResults($number);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function asArray(): array
    {
        return $this->qb->getQuery()->getResult();
    }

    /**
     * @return object
     */
    public function first()
    {
        return $this->qb->getQuery()->getSingleResult();
    }
}