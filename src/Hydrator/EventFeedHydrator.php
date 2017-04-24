<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\EventFeedDTO;
use Aulinks\Entity\Event;

/**
 * Class EventFeedHydrator
 * @package Aulinks\Hydrator
 */
class EventFeedHydrator implements HydratorInterface
{
    /**
     * @param mixed $data
     * @param null $dto
     */
    public function hydrate($data, $dto = null)
    {
        if (!$data instanceof Event) {
            throw new \Exception();
        }

        if (null === $dto) {
            $dto = new EventFeedDTO();
        }

        $dto->setId($data->getId());
        $dto->setTitle($data->getName());
        $dto->setStart($data->getDate());
        $dto->setStatus($data->getStatus());
        $dto->setDescription($data->getDescription());
        $dto->setColor($data->getColorHex());
        $dto->setAuthor($data->getUser()->getUsername());
    }
}