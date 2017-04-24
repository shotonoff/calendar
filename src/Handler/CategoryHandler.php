<?php declare(strict_types = 1);

namespace Aulinks\Handler;

use Aulinks\Entity\Category;
use Aulinks\Repository\CategoryRepository;
use Aulinks\Specification\AndXSpecification;

/**
 * Class CategoryHandler
 * @package Aulinks\Handler
 */
class CategoryHandler
{
    /** @var CategoryRepository */
    private $repository;

    /**
     * CategoryHandler constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        $collection = $this->repository->getBySpecification(new AndXSpecification());
        return $collection->asArray();
    }

    /**
     * @param int $id
     * @return Category
     */
    public function getCategory(int $id): Category
    {
        return $this->repository->find($id);
    }

    /**
     * @param Category $entity
     */
    public function save(Category $entity)
    {
        $this->repository->save($entity);
    }
}