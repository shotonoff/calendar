<?php declare(strict_types = 1);

namespace Aulinks\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="\Aulinks\Repository\EventRepository")
 * @ORM\Table(name="events")
 *
 * Class Event
 * @package Aulinks\Entity
 */
class Event extends EntityAbstract
{
    const STATUS_NEW = 1;
    const STATUS_INPROGRESS = 2;
    const STATUS_DONE = 3;

    /**
     * @ORM\Column(name="name", type="string", length=64)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="created_at", type="date")
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @ORM\Column(name="date", type="datetime")
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @ORM\Column(name="description", type="text", length=2000)
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="\Aulinks\Entity\User", inversedBy="events")
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="status", type="integer")
     * @var int
     */
    private $status = self::STATUS_NEW;

    /**
     * @ORM\Column(name="color_hex", type="string")
     * @var string
     */
    private $colorHex;

    /**
     * @ORM\Column(name="is_deleted", type="boolean")
     * @var bool
     */
    private $deleted = false;

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
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     */
    public function setDate(\DateTimeInterface $date)
    {
        $this->date = $date;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        $user->addEvent($this);
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
    public function getColorHex(): string
    {
        return $this->colorHex;
    }

    /**
     * @param string $colorHex
     */
    public function setColorHex(string $colorHex)
    {
        $this->colorHex = $colorHex;
    }

    /**
     * @return boolean
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted(bool $deleted)
    {
        $this->deleted = $deleted;
    }
}