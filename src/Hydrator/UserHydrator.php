<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\UserRequestDTO;
use Aulinks\Entity\User;
use Aulinks\Security\PasswordHandler;
use Aulinks\Service\InviteService;

/**
 * Class UserHydrator
 * @package Aulinks\Hydrator
 */
class UserHydrator implements HydratorInterface
{
    /** @var PasswordHandler */
    private $passwordHandler;

    /** @var InviteService */
    private $inviteService;

    /**
     * UserHydrator constructor.
     * @param PasswordHandler $passwordHandler
     * @param InviteService $inviteService
     */
    public function __construct(
        PasswordHandler $passwordHandler,
        InviteService $inviteService
    )
    {
        $this->passwordHandler = $passwordHandler;
        $this->inviteService = $inviteService;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($data, $dto = null)
    {
        if (!$data instanceof UserRequestDTO) {
            throw new \Exception();
        }
        if (null === $dto) {
            $dto = new User();
        }
        if (!$data->isNew()) {
            $dto->setId($data->getId());
        }
        $dto->setEmail($data->getEmail());
        $dto->setUsername($data->getUsername());
        $dto->setPassword(
            $this->passwordHandler->hash($data->getPassword())
        );

        if ($data->isAdmin()) {
            $dto->addRole(User::ADMIN_ROLE);
        }
    }
}