<?php declare(strict_types = 1);

namespace Aulinks\Security;

use Aulinks\Entity\User;
use Aulinks\Hydrator\HydratorInterface;
use Aulinks\Hydrator\TokenHydrator;
use Aulinks\Repository\UserRepository;

/**
 * Class JwtAuthProcessor
 * @package Aulinks\Security
 */
class JwtAuthProcessor
{
    /** @var HydratorInterface */
    private $hydrator;

    /** @var JwtSession */
    private $session;

    /**
     * JwtCallbackAuthentication constructor.
     * @param TokenHydrator $hydrator
     * @param JwtSession $session
     * @param UserRepository $repository
     */
    public function __construct(
        TokenHydrator $hydrator,
        JwtSession $session,
        UserRepository $repository
    )
    {
        $this->hydrator = $hydrator;
        $this->session = $session;
        $this->repository = $repository;
    }

    /**
     * @param \StdClass $decoded
     */
    public function processes($decoded)
    {
        $token = new JwtToken();
        $this->hydrator->hydrate($decoded, $token);
        $id = (int)$decoded->scope->id;
        /** @var User $user */
        $user = $this->repository->find($id);
        $token->setUser($user);
        $this->session->setToken($token);
    }
}