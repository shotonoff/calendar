<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\EventDTO;
use Aulinks\Entity\Event;

/**
 * Class EventResponseHydrator
 * @package Aulinks\Hydrator
 */
class EventResponseHydrator implements HydratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate($event, $dto = null)
    {
        if (!$event instanceof Event) {
            throw new \Exception();
        }

        if ($dto === null) {
            $dto = new EventDTO();
        }

        $dto->setId($event->getId());
        $dto->setName($event->getName());
        $date = $event->getDate();
        if (!$date instanceof \DateTimeImmutable) {
            $date = \DateTimeImmutable::createFromMutable($event->getDate());
        }
        $dto->setDate($date);
        $dto->setStatus($event->getStatus());
        $dto->setDescription($event->getDescription());
        $dto->setColorHex($event->getColorHex());
        return $dto;
    }
}