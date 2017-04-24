<?php declare(strict_types = 1);

namespace Aulinks\DTO;

use JMS\Serializer\Annotation as JMS;

/**
 * Class InviteRequestDTO
 * @package Aulinks\DTO
 */
class InviteRequestDTO
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("email")
     *
     * @var string
     */
    private $email;

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
}