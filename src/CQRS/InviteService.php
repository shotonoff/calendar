<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\Entity\Invite;
use Aulinks\Hydrator\InviteRequestHydrator;
use Aulinks\Repository\InviteRepository;
use Aulinks\Service\InviteService as Service;

/**
 * Class InviteService
 * @package Aulinks\CQRS
 */
class InviteService
{
    /** @var InviteRepository */
    private $repository;

    /** @var Service */
    private $inviteService;

    /** @var \Swift_Mailer */
    private $mailer;

    /** @var InviteRequestHydrator */
    private $requestDTOHydrator;

    /**
     * UserService constructor.
     * @param InviteRepository $repository
     * @param Service $inviteService
     * @param \Swift_Mailer $mailer $inviteService
     * @param InviteRequestHydrator $requestDTOHydrator
     */
    public function __construct(
        InviteRepository $repository,
        Service $inviteService,
        \Swift_Mailer $mailer,
        InviteRequestHydrator $requestDTOHydrator
    )
    {
        $this->repository = $repository;
        $this->inviteService = $inviteService;
        $this->mailer = $mailer;
        $this->requestDTOHydrator = $requestDTOHydrator;
    }

    /**
     * @param InviteCreateCommand $command
     */
    public function inviteCreate(InviteCreateCommand $command)
    {
        $invite = new Invite();
        $this->requestDTOHydrator->hydrate($command->inviteDTO, $invite);
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
}