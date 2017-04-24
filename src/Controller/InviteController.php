<?php declare(strict_types = 1);

namespace Aulinks\Controller;

use Aulinks\CQRS\InviteCreateCommand;
use Aulinks\DTO\InviteRequestDTO;
use Aulinks\DTO\InviteResponseDTO;
use Aulinks\Hydrator\CollectionHydrator;
use Aulinks\Hydrator\InviteRequestHydrator;
use Aulinks\Hydrator\InviteResponseHydrator;
use Aulinks\Repository\InviteRepository;
use Aulinks\Specification\AndXSpecification;
use JMS\Serializer\Serializer;
use LiteCQRS\Bus\DirectCommandBus;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class InviteController
 * @package Aulinks\Controller
 */
class InviteController
{
    /** @var DirectCommandBus */
    private $commandBus;

    /** @var Serializer */
    private $serializer;

    /** @var InviteRepository */
    private $repository;

    /** @var InviteRequestHydrator */
    private $requestDTOHydrator;

    /** @var InviteResponseHydrator */
    private $responseDTOHydrator;

    /**
     * InviteController constructor.
     * @param DirectCommandBus $commandBus
     * @param Serializer $serializer
     * @param InviteRepository $repository
     * @param InviteRequestHydrator $requestDTOHydrator
     * @param InviteResponseHydrator $responseDTOHydrator
     */
    public function __construct(
        DirectCommandBus $commandBus,
        Serializer $serializer,
        InviteRepository $repository,
        InviteRequestHydrator $requestDTOHydrator,
        InviteResponseHydrator $responseDTOHydrator
    )
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->requestDTOHydrator = $requestDTOHydrator;
        $this->responseDTOHydrator = $responseDTOHydrator;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function postInviteCreateAction(Request $request, Response $response)
    {
        $inviteDTO = $this->serializer->deserialize((string)$request->getBody(), InviteRequestDTO::class, 'json');
        $this->commandBus->handle(new InviteCreateCommand(['inviteDTO' => $inviteDTO]));
        return $response->withStatus(201);
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function getInvitesAction(Request $request, Response $response)
    {
        $hydrator = new CollectionHydrator(
            $this->responseDTOHydrator,
            function () {
                return new InviteResponseDTO();
            }
        );

        $hydrator->hydrate(
            $this->repository->getBySpecification(new AndXSpecification())->asArray()
        );

        $response->getBody()->write(
            $this->serializer->serialize($hydrator->getHydratedResult(), 'json')
        );
    }
}