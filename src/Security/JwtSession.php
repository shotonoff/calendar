<?php declare(strict_types = 1);

namespace Aulinks\Security;

/**
 * Class JwtSession
 * @package Aulinks\Security
 */
class JwtSession
{
    /** @var JwtToken */
    private $token;

    /**
     * @param JwtToken $token
     */
    public function setToken(JwtToken $token)
    {
        $this->token = $token;
    }

    /**
     * @return JwtToken
     */
    public function getToken(): JwtToken
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function hasToken(): bool
    {
        return $this->token !== null;
    }
}