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
        $start = $event->getStart();
        if (!$start instanceof \DateTimeImmutable) {
            $start = \DateTimeImmutable::createFromMutable($event->getStart());
        }
        $dto->setStart($start);

        $end = $event->getEnd();
        if (!$end instanceof \DateTimeImmutable) {
            $end = \DateTimeImmutable::createFromMutable($event->getEnd());
        }
        $dto->setEnd($end);
        $dto->setStatus($event->getStatus());
        $dto->setDescription($event->getDescription());
        $dto->setColorHex($event->getColorHex());
        return $dto;
    }
}