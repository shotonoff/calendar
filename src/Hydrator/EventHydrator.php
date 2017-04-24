<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\DTO\EventDTO;
use Aulinks\Entity\Event;

/**
 * Class EventHydrator
 * @package Aulinks\Hydrator
 */
class EventHydrator implements HydratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate($data, $dto = null)
    {
        if (!$data instanceof EventDTO) {
            throw new \Exception();
        }

        if (null === $dto) {
            $dto = new Event();
        }

        if ($data->isNew()) {
            $dto->setCreatedAt(new \DateTimeImmutable());
        } else {
            $dto->setId($data->getId());
        }
        try {
            $dto->setName($data->getName());
        } catch (\Throwable $e) {
            // do nothing
        }
        try {
            $dto->setDate($data->getDate());
        } catch (\Throwable $e) {
            // do nothing
        }
        try {
            $dto->setStatus($data->getStatus());
        } catch (\Throwable $e) {
            // do nothing
        }
        try {
            $dto->setDescription($data->getDescription());
        } catch (\Throwable $e) {
            // do nothing
        }
        try {
            $dto->setColorHex($data->getColorHex());
        } catch (\Throwable $e) {
            // do nothing
        }
    }
}