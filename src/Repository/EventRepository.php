<?php declare(strict_types = 1);

namespace Aulinks\Repository;

use Aulinks\Entity\Event;
use Aulinks\Repository\Collection\LazyDoctrineCollection;
use Aulinks\Specification\CollectionInterface;
use Aulinks\Specification\SpecificationInterface;

/**
 * Class EventRepository
 * @package Aulinks\Repository
 */
class EventRepository extends RepositoryAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getBySpecification(SpecificationInterface $specification): CollectionInterface
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')->from(Event::class, 'e');
        $specification->isSatisfiedBy($qb);
        return new LazyDoctrineCollection($qb);
    }
}