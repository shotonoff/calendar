<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\InviteRequestDTO;
use Aulinks\Entity\Invite;
use Aulinks\Hydrator\InviteRequestHydrator;
use Aulinks\Repository\InviteRepository;

use Aulinks\Service\InviteService as Service;
use JMS\Serializer\Serializer;
use Slim\Http\RequestBody;

/**
 * Class InviteService
 * @package Aulinks\CQRS
 */
class InviteService
{
    /** @var Serializer */
    private $serializer;

    /**
     * UserService constructor.
     * @param InviteRepository $repository
     * @param Service $inviteService
     * @param Serializer $serializer
     * @param \Swift_Mailer $mailer $inviteService
     * @param InviteRequestHydrator $requestDTOHydrator
     */
    public function __construct(
        InviteRepository $repository,
        Service $inviteService,
        Serializer $serializer,
        \Swift_Mailer $mailer,
        InviteRequestHydrator $requestDTOHydrator
    )
    {
        $this->repository = $repository;
        $this->inviteService = $inviteService;
        $this->mailer = $mailer;
        $this->serializer = $serializer;
        $this->requestDTOHydrator = $requestDTOHydrator;
    }

    /**
     * @param InviteCreateCommand $command
     */
    public function inviteCreate(InviteCreateCommand $command)
    {
        $dto = $this->serialize($command->data);
        $invite = new Invite();
        $this->requestDTOHydrator->hydrate($dto, $invite);
        $invite->setExpired((new \DateTime())->modify("+2 days"));
        $this->repository->save($invite);
        $token = $this->inviteService->createInviteToken($invite);
        $invite->setToken($token);
        $this->repository->save($invite);
        $this->inviteSend(
            new InviteSendCommand(['email' => $invite->getEmail(), 'token' => $invite->getToken()])
        );
    }

    /**
     * @param InviteSendCommand $command
     */
    public function inviteSend(InviteSendCommand $command)
    {
        $mail = \Swift_Message::newInstance()
            ->setSubject('Aulinks user activation')
            ->setFrom('robot@aulinks.com')
            ->setTo($command->email)
            ->setBody(
                sprintf('<a href="http://aulinks.local/#/registration?invite=%s"></a>', $command->token),
                'text/html');
        $this->mailer->send($mail);
    }

    /**
     * @param string|array $data
     * @return array
     */
    private function serialize($data)
    {
        if (is_string($data) || $data instanceof RequestBody) {
            return $this->serializer->deserialize((string)$data, InviteRequestDTO::class, 'json');
        }
        return $this->serializer->fromArray($data, InviteRequestDTO::class);
    }
}