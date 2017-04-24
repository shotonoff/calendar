<?php declare(strict_types = 1);

namespace Aulinks\Repository;

use Doctrine\ORM\EntityRepository;
use Aulinks\Entity\EntityAbstract;
use Aulinks\Specification\Specificable;

/**
 * Class RepositoryAbstract
 * @package Aulinks\Repository
 */
abstract class RepositoryAbstract extends EntityRepository implements Specificable
{
    /**
     * @param EntityAbstract $entity
     */
    public function save(EntityAbstract $entity)
    {
        if ($entity->isNew()) {
            $this->createEntity($entity);
        } else {
            $this->updateEntity($entity);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @param EntityAbstract $entity
     */
    protected function createEntity(EntityAbstract $entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @param EntityAbstract $entity
     */
    protected function updateEntity(EntityAbstract $entity)
    {
        $this->getEntityManager()->merge($entity);
    }
}