<?php declare(strict_types=1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\AccessType("public_method")
 *
 * Class UserRequestDTO
 * @package Aulinks\DTO
 */
class UserRequestDTO
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
     * @JMS\Type("string")
     * @JMS\SerializedName("password")
     *
     * @var
     */
    private $password;


    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("confirmPassword")
     *
     * @var
     */
    private $confirmPassword;

    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("isAdminRole")
     *
     * @var bool
     */
    private $admin = false;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("token")
     *
     * @var string
     */
    private $inviteToken;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    /**
     * @param boolean $admin
     */
    public function setAdmin(bool $admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->id === null;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @return string
     */
    public function getInviteToken(): string
    {
        return $this->inviteToken;
    }

    /**
     * @param string $inviteToken
     */
    public function setInviteToken(string $inviteToken)
    {
        $this->inviteToken = $inviteToken;
    }
}