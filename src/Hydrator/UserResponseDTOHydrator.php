<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\UserResponseDTO;
use Aulinks\Entity\User;

/**
 * Class UserResponseDTOHydrator
 * @package Aulinks\Hydrator
 */
class UserResponseDTOHydrator implements HydratorInterface
{

    public function hydrate($user, $dto = null)
    {
        if (!$user instanceof User) {
            throw new \Exception();
        }
        if (null === $dto) {
            $dto = new UserResponseDTO();
        }
        $dto->setEmail($user->getEmail());
        $dto->setId($user->getId());
        $dto->setUsername($user->getUsername());
        $dto->setCreatedAt($user->getCreatedAt());
        $dto->setRoles($user->getRoles());
        $dto->setActive($user->isActive());
    }
}