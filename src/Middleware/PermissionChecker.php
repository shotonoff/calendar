<?php declare(strict_types = 1);

namespace Aulinks\Middleware;

use Aulinks\Security\UserProvider;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Route;

/**
 * Class PermissionChecker
 * @package Aulinks\Middleware
 */
class PermissionChecker
{
    /** @var UserProvider */
    private $userProvider;

    /**
     * PermissionChecker constructor.
     * @param UserProvider $userProvider
     */
    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(Request $request, ResponseInterface $response, callable $next)
    {
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $permissions = $route->getArgument('action.permission');
        if(null === $permissions) {
            return $next($request, $response);
        }
        if(is_string($permissions)) {
            $permissions = [$permissions];
        }

        if (!$this->userProvider->isAuthorized() || !$this->userProvider->isGranted($permissions)) {
            return $response->withStatus(403);
        }
        return $next($request, $response);
    }
}