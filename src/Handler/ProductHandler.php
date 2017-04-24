<?php declare(strict_types = 1);

namespace Aulinks\Handler;

use Aulinks\Entity\EntityAbstract;
use Aulinks\Entity\Product;
use Aulinks\Repository\ProductRepository;

/**
 * Class ProductHandler
 * @package Aulinks\Handler
 */
class ProductHandler
{
    /** @var ProductRepository */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getProduct(int $id): Product
    {
        return $this->repository->find($id);
    }

    /**
     * @param Product $product
     */
    public function save(Product $product)
    {
        $this->repository->save($product);
    }
}