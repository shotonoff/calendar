<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\InviteResponseDTO;
use Aulinks\Entity\Invite;

/**
 * Class InviteResponseHydrator
 * @package Aulinks\Hydrator
 */
class InviteResponseHydrator implements HydratorInterface
{
    /**
     * @param mixed $entity
     * @param null $dto
     */
    public function hydrate($entity, $dto = null)
    {
        if (!$entity instanceof Invite) {
            throw new \Exception();
        }
        if (null === $dto) {
            $dto = new InviteResponseDTO();
        }
        $dto->setId($entity->getId());
        $dto->setToken($entity->getToken());
        $dto->setCreatedAt($entity->getCreatedAt());
        $dto->setEmail($entity->getEmail());
        $dto->setActive($entity->isActive());
        $dto->setExpired($entity->getExpired());
    }
}