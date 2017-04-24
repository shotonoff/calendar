<?php declare(strict_types = 1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\AccessType("public_method")
 *
 * Class UserResponseDTO
 * @package Aulinks\DTO
 */
class UserResponseDTO
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
     * @JMS\SerializedName("email")
     *
     * @var string
     */
    private $email;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("username")
     *
     * @var string
     */
    private $username;

    /**
     * @JMS\Type("array")
     * @JMS\SerializedName("roles")
     *
     * @var array
     */
    private $roles = [];

    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("active")
     *
     * @var bool
     */
    private $active;

    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("createdAt")
     *
     * @var \DateTime
     */
    private $createdAt;

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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
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
}