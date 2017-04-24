<?php declare(strict_types = 1);

namespace Aulinks\Repository\Specification;

use Aulinks\Specification\SpecificationInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class EventPeriodSpecification
 * @package Aulinks\Repository\Specification
 */
class EventPeriodSpecification implements SpecificationInterface
{
    /** @var string */
    private $start;

    /** @var string */
    private $end;

    /**
     * EventPeriodSpecification constructor.
     * @param string $start
     * @param string $end
     */
    public function __construct(string $start, string $end)
    {
        $this->start = new \DateTime($start);
        $this->start->setTime(0, 0, 0);
        $this->end = new \DateTime($end);
        $this->end->modify('+1 days');
        $this->end->setTime(0, 0, 0);
    }

    /**
     * @param QueryBuilder $qb
     * @return bool
     */
    public function isSatisfiedBy($qb): bool
    {
        $qb
            ->andWhere($qb->expr()->gte('e.date', ':start'))->setParameter('start', $this->start)
            ->andWhere($qb->expr()->lte('e.date', ':end'))->setParameter('end', $this->end)
        ;
        return true;
    }
}