<?php declare(strict_types = 1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\AccessType("public_method")
 *
 * Class EventDTO
 * @package Aulinks\DTO
 */
class EventDTO
{
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("id")
     *
     * @var int
     */
    private $id;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("name")
     *
     * @var string
     */
    private $name;

    /**
     * @JMS\Type("DateTimeImmutable<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("start")
     *
     * @var \DateTimeInterface
     */
    private $start;

    /**
     * @JMS\Type("DateTimeImmutable<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("end")
     *
     * @var \DateTimeInterface
     */
    private $end;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("description")
     *
     * @var string
     */
    private $description;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("status")
     *
     * @var int
     */
    private $status;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("colorHex")
     *
     * @var string
     */
    private $colorHex;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getColorHex()
    {
        return $this->colorHex;
    }

    /**
     * @param mixed $colorHex
     */
    public function setColorHex($colorHex)
    {
        $this->colorHex = $colorHex;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->id === null;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTimeInterface $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTimeInterface $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }
}