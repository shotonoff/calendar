<?php declare(strict_types = 1);

namespace Aulinks\Security;

use Aulinks\Entity\User;

/**
 * Class UserProvider
 * @package Aulinks\Security
 */
class UserProvider
{
    const PERMISSIONS = [
        User::ADMIN_ROLE => [
            'event.all',
            'user.all',
            'invite.all',
        ],
        User::NORMAL_ROLE => [
            'event.get',
            'event.list',
            'event.create',
            'event.update',
            'event.delete',
        ],
    ];

    /** @var PasswordHandler */
    private $handler;

    /** @var JwtSession */
    private $session;

    /**
     * UserProvider constructor.
     * @param PasswordHandler $handler
     * @param JwtSession $session
     */
    public function __construct(
        PasswordHandler $handler,
        JwtSession $session
    )
    {
        $this->handler = $handler;
        $this->session = $session;
    }

    /**
     * @param string $password
     * @return string
     */
    public function generatePasswordHash(string $password)
    {
        return $this->handler->hash($password);
    }

    /**
     * @param string $password
     * @param UserInterface $user
     * @return bool
     */
    public function verify(string $password, UserInterface $user): bool
    {
        return $this->handler->verify($password, $user->getPassword());
    }

    /**
     * @param UserInterface $user
     * @return array
     */
    public function getPermissions(UserInterface $user)
    {
        $permissions = [];
        $roles = $user->getRoles();
        if (count($roles) === 0) {
            return self::PERMISSIONS[User::NORMAL_ROLE];
        }
        foreach ($roles as $role) {
            if (!array_key_exists($role, self::PERMISSIONS)) {
                continue;
            }
            $permissions = array_merge($permissions, self::PERMISSIONS[$role]);
        }
        return $permissions;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function isGranted(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->session->getToken()->hasPermissions([$permission])) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->session->hasToken();
    }

    /**
     * @return JwtToken
     */
    public function getToken(): JwtToken
    {
        return $this->session->getToken();
    }
}