<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\EventDTO;
use Aulinks\Entity\Event;
use Aulinks\Exception\ForbiddenException;
use Aulinks\Hydrator\EventHydrator;
use Aulinks\Repository\EventRepository;
use Aulinks\Security\UserProvider;
use JMS\Serializer\Serializer;
use Slim\Http\RequestBody;

/**
 * Class UserService
 * @package Aulinks\Service
 */
class EventService
{
    /** @var EventRepository */
    private $repository;

    /** @var EventHydrator */
    private $hydrator;

    /** @var UserProvider */
    private $userProvider;

    /**
     * UserService constructor.
     * @param EventRepository $repository
     * @param EventHydrator $hydrator
     * @param UserProvider $userProvider
     */
    public function __construct(
        EventRepository $repository,
        EventHydrator $hydrator,
        UserProvider $userProvider
    )
    {
        $this->repository = $repository;
        $this->hydrator = $hydrator;
        $this->userProvider = $userProvider;
    }

    /**
     * @param EventCreateCommand $command
     */
    public function eventCreate(EventCreateCommand $command)
    {
        $event = new Event();
        $this->hydrator->hydrate($command->eventDTO, $event);
        $event->setUser($this->userProvider->getToken()->getUser());
        $this->repository->save($event);
    }

    /**
     * @param EventPartUpdateCommand $command
     * @throws \Exception
     */
    public function eventPartUpdate(EventPartUpdateCommand $command)
    {
        /** @var Event $event */
        $event = $this->repository->find((int)$command->id);
        if ($event->isDeleted()) {
            throw new ForbiddenException();
        }
        $this->failedIfNotOwner($event, $command->userId);
        $this->hydrator->hydrate($command->eventDTO, $event);
        $this->repository->save($event);
    }

    /**
     * @param EventDeleteCommand $command
     */
    public function eventDelete(EventDeleteCommand $command)
    {
        /** @var Event $event */
        $event = $this->repository->find((int)$command->id);
        $this->failedIfNotOwner($event, $command->userId);
        $event->setDeleted(true);
        $this->repository->save($event);
    }

    /**
     * @param Event $event
     * @param int $userId
     */
    private function failedIfNotOwner(Event $event, int $userId)
    {
        if ($event->getUser()->getId() !== $userId) {
            throw ForbiddenException::invalidEventOwner();
        }
    }
}