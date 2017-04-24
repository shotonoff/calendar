<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\InviteRequestDTO;
use Aulinks\Entity\Invite;

/**
 * Class InviteRequestHydrator
 * @package Aulinks\Hydrator
 */
class InviteRequestHydrator implements HydratorInterface
{
    /**
     * @param mixed $data
     * @param null $dto
     * @throws \Exception
     */
    public function hydrate($dto, $entity = null)
    {
        if (!$dto instanceof InviteRequestDTO) {
            throw new \Exception();
        }
        if (null === $entity) {
            $entity = new Invite();
        }
        $entity->setEmail($dto->getEmail());
    }
}