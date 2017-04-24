<?php declare(strict_types = 1);

namespace Aulinks\Middleware;

use Aulinks\Security\UserProvider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Aulinks\Entity\User;

/**
 * Class RoleAccessChecker
 * @package Aulinks\Middleware
 */
class RoleAccessChecker
{
    /** @var UserProvider */
    private $userProvider;

    /**
     * RoleAccessChecker constructor.
     * @param UserProvider $userProvider
     */
    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider  =$userProvider;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        /** @var \Aulinks\Entity\User $user */
        $user = $this->userProvider->getToken()->getUser();
        if(!$user->hasRole(User::ADMIN_ROLE)) {
            $response->withStatus(403);
            return $response;
        }
        return $next($request, $response);
    }
}