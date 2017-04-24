<?php declare(strict_types = 1);

namespace Aulinks\Repository;

use Aulinks\Entity\Invite;
use Aulinks\Repository\Collection\LazyDoctrineCollection;
use Aulinks\Specification\CollectionInterface;
use Aulinks\Specification\SpecificationInterface;

/**
 * Class InviteRepository
 * @package Aulinks\Repository
 */
class InviteRepository extends RepositoryAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getBySpecification(SpecificationInterface $specification): CollectionInterface
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')->from(Invite::class, 'i')->orderBy('i.createdAt', 'desc');
        $specification->isSatisfiedBy($qb);
        return new LazyDoctrineCollection($qb);
    }
}