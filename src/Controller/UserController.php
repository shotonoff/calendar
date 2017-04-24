<?php declare(strict_types = 1);

namespace Aulinks\Controller;

use Aulinks\CQRS\UserCreateCommand;
use Aulinks\CQRS\UserUpdateCommand;
use Aulinks\DTO\UserRequestDTO;
use Aulinks\DTO\UserRequestUpdateDTO;
use Aulinks\DTO\UserResponseDTO;
use Aulinks\Hydrator\CollectionHydrator;
use Aulinks\Hydrator\UserResponseDTOHydrator;
use Aulinks\Repository\UserRepository;
use Aulinks\Specification\AndXSpecification;
use JMS\Serializer\Serializer;
use LiteCQRS\Bus\DirectCommandBus;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class UserController
 * @package Aulinks\Controller
 */
class UserController
{
    /** @var DirectCommandBus */
    private $commandBus;

    /** @var UserRepository */
    private $repository;

    /** @var Serializer */
    private $serializer;

    /** @var UserResponseDTOHydrator */
    private $userResponseHydrator;

    /**
     * UserController constructor.
     * @param DirectCommandBus $commandBus
     * @param UserRepository $repository
     * @param Serializer $serializer
     * @param UserResponseDTOHydrator $userResponseHydrator
     */
    public function __construct(
        DirectCommandBus $commandBus,
        UserRepository $repository,
        Serializer $serializer,
        UserResponseDTOHydrator $userResponseHydrator
    )
    {
        $this->commandBus = $commandBus;
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->userResponseHydrator = $userResponseHydrator;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function postUserCreateAction(Request $request, Response $response)
    {
        $dto = $this->serializer->deserialize((string)$request->getBody(), UserRequestDTO::class, 'json');
        $this->commandBus->handle(new UserCreateCommand([
            'userDTO' => $dto,
            'inviteCheckSkip' => false,
        ]));
        return $response->withStatus(201);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getUsersAction(Request $request, Response $response)
    {
        $hydrator = new CollectionHydrator(
            $this->userResponseHydrator,
            function () {
                return new UserResponseDTO();
            }
        );
        $hydrator->hydrate(
            $this->repository->getBySpecification(new AndXSpecification())->asArray()
        );
        $response->getBody()->write(
            $this->serializer->serialize($hydrator->getHydratedResult(), 'json')
        );
        return $response->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param int $id
     * @return Response
     */
    public function getUserAction(Request $request, Response $response, $id)
    {
        $user = $this->repository->find((int)$id);
        $dto = new UserResponseDTO();
        $this->userResponseHydrator->hydrate($user, $dto);
        $response->getBody()->write(
            $this->serializer->serialize($dto, 'json')
        );
        return $response->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function putUserUpdateAction(Request $request, Response $response)
    {
        $userDTO = $this->serializer->deserialize((string)$request->getBody(), UserRequestUpdateDTO::class, 'json');
        $this->commandBus->handle(new UserUpdateCommand([
            'userDTO' => $userDTO
        ]));
        return $response->withStatus(200);
    }
}