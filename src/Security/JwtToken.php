<?php declare(strict_types = 1);

namespace Aulinks\Security;

use Aulinks\Entity\User;

/**
 * Class JwtToken
 * @package Aulinks\Security
 */
class JwtToken
{
    /** @var array */
    private $permissions = [];

    /** @var User */
    private $user;

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions(array $permissions)
    {
        if(in_array('*', $this->permissions)) {
            return true;
        }
        return !!count(array_intersect($permissions, $this->permissions));
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}