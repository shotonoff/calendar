<?php declare(strict_types = 1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\AccessType("public_method")
 *
 * Class EventFeedDTO
 * @package Aulinks\DTO
 */
class EventFeedDTO
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
     * @JMS\SerializedName("title")
     *
     * @var string
     */
    private $title;

    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("start")
     *
     * @var \DateTimeInterface
     */
    private $start;

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
     * @JMS\SerializedName("color")
     *
     * @var string
     */
    private $color;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("author")
     *
     * @var string
     */
    private $author;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart(): \DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @param \DateTimeInterface $start
     */
    public function setStart(\DateTimeInterface $start)
    {
        $this->start = $start;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color)
    {
        $this->color = $color;
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

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
}