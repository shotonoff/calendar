<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

/**
 * Class CollectionHydrator
 * @package Aulinks\Hydrator
 */
class CollectionHydrator implements HydratorInterface
{
    /** @var HydratorInterface */
    private $hydrator;

    /** @var array */
    private $result;

    /** @var callable */
    private $creator;

    /**
     * CollectionHydrator constructor.
     * @param HydratorInterface $hydrator
     * @param callable $creator
     */
    public function __construct(
        HydratorInterface $hydrator,
        callable $creator
    )
    {
        $this->hydrator = $hydrator;
        $this->creator = $creator;
    }

    /**
     * @param mixed $items
     * @param null $dto
     * @return array
     */
    public function hydrate($items, $dto = null)
    {
        $this->result = [];
        foreach ($items as $item) {
            $obj = call_user_func($this->creator);
            $this->hydrator->hydrate($item, $obj);
            $this->result[] = $obj;
        }
        return $this->result;
    }

    /**
     * @return array
     */
    public function getHydratedResult(): array
    {
        return $this->result;
    }
}