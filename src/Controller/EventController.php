<?php declare(strict_types = 1);

namespace Aulinks\Controller;

use Aulinks\CQRS\EventCreateCommand;
use Aulinks\CQRS\EventDeleteCommand;
use Aulinks\CQRS\EventPartUpdateCommand;
use Aulinks\DTO\EventDTO;
use Aulinks\DTO\EventFeedDTO;
use Aulinks\Entity\User;
use Aulinks\Exception\ForbiddenException;
use Aulinks\Hydrator\CollectionHydrator;
use Aulinks\Hydrator\EventFeedHydrator;
use Aulinks\Hydrator\EventResponseHydrator;
use Aulinks\Repository\EventRepository;
use Aulinks\Repository\Specification\EventNotDeletedSpecification;
use Aulinks\Repository\Specification\EventPeriodSpecification;
use Aulinks\Repository\Specification\EventUserIdSpecification;
use Aulinks\Security\UserProvider;
use Aulinks\Specification\AndXSpecification;
use JMS\Serializer\Serializer;
use LiteCQRS\Bus\DirectCommandBus;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class EventController
 * @package Aulinks\Controller
 */
class EventController
{
    /** @var DirectCommandBus */
    private $commandBus;

    /** @var UserProvider */
    private $userProvider;

    /** @var EventRepository */
    private $repository;

    /** @var EventResponseHydrator */
    private $dtoHydrator;

    /**
     * EventController constructor.
     * @param DirectCommandBus $commandBus
     * @param UserProvider $userProvider
     * @param EventRepository $repository
     * @param Serializer $serializer
     * @param EventResponseHydrator $dtoHydrator
     */
    public function __construct(
        DirectCommandBus $commandBus,
        UserProvider $userProvider,
        EventRepository $repository,
        Serializer $serializer,
        EventResponseHydrator $dtoHydrator
    )
    {
        $this->commandBus = $commandBus;
        $this->userProvider = $userProvider;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->dtoHydrator = $dtoHydrator;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function postEventCreateAction(Request $request, Response $response)
    {
        if ($request->getAttribute('has_errors')) {
            return $response->withStatus(400, ['error' => $request->getAttribute('errors')]);
        }
        $this->commandBus->handle(new EventCreateCommand(['data' => $request->getParsedBody()]));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param int $id
     * @return Response
     */
    public function patchChangeDateAction(Request $request, Response $response, $id)
    {
        $this->commandBus->handle(new EventPartUpdateCommand([
            'id' => $id,
            'userId' => $this->userProvider->getToken()->getUser()->getId(),
            'data' => $request->getParsedBody()
        ]));
        return $response->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getEventsAction(Request $request, Response $response)
    {
        $andXSpec = new AndXSpecification(new EventNotDeletedSpecification());
        /** @var User $user */
        $user = $this->userProvider->getToken()->getUser();
        if (!$user->hasRole(User::ADMIN_ROLE)) {
            $andXSpec->and(new EventUserIdSpecification($user->getId()));
        }
        $events = $this->repository->getBySpecification($andXSpec)->asArray();

        $hydrator = new CollectionHydrator(
            $this->dtoHydrator,
            function () {
                return new EventDTO();
            }
        );
        $hydrator->hydrate($events);
        $response->getBody()->write(
            $this->serializer->serialize($hydrator->getHydratedResult(), 'json')
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getEventsFeedAction(Request $request, Response $response)
    {
        if ($request->getAttribute('has_errors')) {
            $errors = $request->getAttribute('errors');
            return $response->withStatus(400)->write(json_encode(['error' => $errors]));
        }

        /** @var User $user */
        $user = $this->userProvider->getToken()->getUser();

        $andXSpec = new AndXSpecification(
            new EventNotDeletedSpecification(),
            new EventPeriodSpecification(
                $request->getQueryParam('start'),
                $request->getQueryParam('end')
            ),
            new EventUserIdSpecification($user->getId())
        );

        $events = $this->repository->getBySpecification($andXSpec)->asArray();

        $hydrator = new CollectionHydrator(
            new EventFeedHydrator(),
            function () {
                return new EventFeedDTO();
            }
        );
        $hydrator->hydrate($events);
        $response->getBody()->write(
            $this->serializer->serialize($hydrator->getHydratedResult(), 'json')
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param int $id
     */
    public function getEventAction(Request $request, Response $response, $id)
    {
        $event = $this->repository->find((int)$id);
        if ($event->isDeleted()) {
            throw new ForbiddenException();
        }
        $dto = new EventDTO();
        $this->dtoHydrator->hydrate($event, $dto);
        $response->getBody()->write(
            $this->serializer->serialize($dto, 'json')
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param int $id
     * @return Response
     */
    public function deleteEventAction(Request $request, Response $response, $id)
    {
        $this->commandBus->handle(new EventDeleteCommand([
            'id' => $id,
            'userId' => $this->userProvider->getToken()->getUser()->getId(),
        ]));
        return $response->withStatus(201);

    }
}