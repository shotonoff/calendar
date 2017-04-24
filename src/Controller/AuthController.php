<?php declare(strict_types = 1);

namespace Aulinks\Controller;

use Aulinks\Entity\User;
use Aulinks\Repository\Specification\LoginSpecification;
use Aulinks\Repository\UserRepository;
use Aulinks\Security\JwtToken;
use Aulinks\Security\JwtTokenProvider;
use Aulinks\Security\PasswordHandler;
use Aulinks\Security\UserProvider;
use Doctrine\ORM\NoResultException;
use Firebase\JWT\JWT;
use LiteCQRS\Bus\DirectCommandBus;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Tuupola\Base62;

/**
 * Class AuthController
 * @package Aulinks\Controller
 */
class AuthController
{
    /** @var DirectCommandBus */
    private $commandBus;

    /** @var UserRepository */
    private $repository;

    /** @var UserProvider */
    private $userProvider;

    /** @var JwtTokenProvider */
    private $tokenProvider;

    /**
     * AuthController constructor.
     * @param DirectCommandBus $commandBus
     * @param UserRepository $repository
     * @param UserProvider $userProvider
     * @param JwtTokenProvider $tokenProvider
     */
    public function __construct(
        DirectCommandBus $commandBus,
        UserRepository $repository,
        UserProvider $userProvider,
        JwtTokenProvider $tokenProvider
    )
    {
        $this->commandBus = $commandBus;
        $this->repository = $repository;
        $this->userProvider = $userProvider;
        $this->tokenProvider = $tokenProvider;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function postTokenAction(Request $request, Response $response)
    {
        $server = $request->getServerParams();

        if (!array_key_exists('PHP_AUTH_USER', $server)) {
            return $response;
        }
        $username = (string)$server['PHP_AUTH_USER'];

        if (!array_key_exists('PHP_AUTH_PW', $server)) {
            return $response;
        }
        $password = (string)$server['PHP_AUTH_PW'];

        try {
            /** @var User $user */
            $user = $this->repository->getBySpecification(new LoginSpecification($username))->first();
        } catch (NoResultException $e) {
            return $response->withStatus(400);
        }
        if (!$this->userProvider->verify($password, $user)) {
            return $response->withStatus(400);
        }

        $perms = $this->userProvider->getPermissions($user);

        $data = $this->tokenProvider->encode([
            'username' => $username,
            'scope' => ['permissions' => $perms, 'id' => $user->getId()]
        ]);
        $data['permissions'] = $perms;

        return $response->withStatus(201)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}