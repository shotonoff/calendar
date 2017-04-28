<?php declare(strict_types = 1);

namespace Aulinks\Repository;

use Aulinks\Entity\Event;
use Aulinks\Repository\Collection\LazyDoctrineCollection;
use Aulinks\Specification\CollectionInterface;
use Aulinks\Specification\SpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class EventRepository
 * @package Aulinks\Repository
 */
class EventRepository extends RepositoryAbstract
{
    /**
     * @param \DateTimeInterface $date
     */
    public function updateStatuses(\DateTimeInterface $date)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->update(Event::class, 'e')
            ->set('e.status', Event::STATUS_INPROGRESS)
            ->where('e.status = :status and e.start < :date')
            ->setParameter('status', Event::STATUS_NEW)
            ->setParameter('date', $date)
            ->getQuery();
        $q->execute();

        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->update(Event::class, 'e')
            ->set('e.status', Event::STATUS_DONE)
            ->where('e.end < :date and e.status in (:statuses)')
            ->setParameter('statuses', [Event::STATUS_INPROGRESS, Event::STATUS_NEW])
            ->setParameter('date', $date)
            ->getQuery();
        $q->execute();
    }

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