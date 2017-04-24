<?php declare(strict_types = 1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * Class UserRequestUpdateDTO
 * @package Aulinks\DTO
 */
class UserRequestUpdateDTO
{
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("id")
     *
     * @var int
     */
    private $id;

    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("active")
     *
     * @var bool
     */
    private $active;

    /**
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}