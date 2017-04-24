<?php declare(strict_types = 1);

namespace Aulinks\Repository;

use Aulinks\Entity\User;
use Aulinks\Repository\Collection\LazyDoctrineCollection;
use Aulinks\Specification\CollectionInterface;
use Aulinks\Specification\SpecificationInterface;

/**
 * Class UserRepository
 * @package Aulinks\Repository
 */
class UserRepository extends RepositoryAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getBySpecification(SpecificationInterface $specification): CollectionInterface
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')->from(User::class, 'u');
        $specification->isSatisfiedBy($qb);
        return new LazyDoctrineCollection($qb);
    }
}