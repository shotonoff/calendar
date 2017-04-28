<?php declare(strict_types = 1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * Class InviteResponseDTO
 * @package Aulinks\DTO
 */
class InviteResponseDTO
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
     * @JMS\SerializedName("token")
     *
     * @var string
     */
    private $token;

    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("createdAt")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("email")
     *
     * @var string
     */
    private $email;

    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("expired")
     *
     * @var \DateTime
     */
    private $expired;

    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("active")
     *
     * @var bool
     */
    private $active;

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
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getExpired(): \DateTime
    {
        return $this->expired;
    }

    /**
     * @param \DateTime $expired
     */
    public function setExpired(\DateTime $expired)
    {
        $this->expired = $expired;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("isExpired")
     */
    public function isExpired(): bool
    {
        return (new \DateTime())->getTimestamp() > $this->expired->getTimestamp();
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("isAvailable")
     * @return bool
     */
    public function isAvailable(): bool
    {
        return !$this->isExpired() && !$this->isActive();
    }
}