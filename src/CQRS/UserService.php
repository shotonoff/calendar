<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\UserRequestDTO;
use Aulinks\DTO\UserRequestUpdateDTO;
use Aulinks\Entity\Invite;
use Aulinks\Entity\User;
use Aulinks\Hydrator\UserHydrator;
use Aulinks\Repository\InviteRepository;
use Aulinks\Repository\UserRepository;
use Aulinks\Service\InviteService;
use JMS\Serializer\Serializer;
use Slim\Http\RequestBody;

/**
 * Class UserService
 * @package Aulinks\Service
 */
class UserService
{
    /** @var UserRepository */
    private $repository;

    /** @var InviteRepository */
    private $inviteRepository;

    /** @var UserHydrator */
    private $hydrator;

    /** @var InviteService */
    private $inviteService;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     * @param InviteRepository $inviteRepository
     * @param UserHydrator $hydrator
     * @param InviteService $inviteService
     * @param \Swift_Mailer $mailer $inviteService
     */
    public function __construct(
        UserRepository $repository,
        InviteRepository $inviteRepository,
        UserHydrator $hydrator,
        InviteService $inviteService,
        \Swift_Mailer $mailer
    )
    {
        $this->repository = $repository;
        $this->inviteRepository = $inviteRepository;
        $this->hydrator = $hydrator;
        $this->inviteService = $inviteService;
        $this->mailer = $mailer;
    }

    /**
     * @param UserCreateCommand $command
     * @throws \Exception
     */
    public function userCreate(UserCreateCommand $command)
    {
        $user = new User();
        if ($command->inviteCheckSkip === false) {
            $token = $this->inviteService->decode($command->userDTO->getInviteToken());
            /** @var Invite $invite */
            $invite = $this->inviteRepository->find((int)$token['id']);
            $this->failedIfInviteInvalid($token, $invite);
            $invite->setActive(true);
            $user->setInvite($invite);
        }

        $user->setActive(true);
        $this->hydrator->hydrate($command->userDTO, $user);
        $this->repository->save($user);

        $this->successfulRegistration(new SuccessfulRegistrationCommand([
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
        ]));
    }

    /**
     * @param array $token
     * @param Invite $invite
     * @throws \Exception
     */
    private function failedIfInviteInvalid(array $token, Invite $invite)
    {
        $now = (new \DateTimeImmutable())->getTimestamp();
        if ((new \DateTimeImmutable($token['expired']))->getTimestamp() < $now) {
            throw new \Exception('Token already have been expired');
        }
        if ($invite->isActive()) {
            throw new \Exception('Token already have activated');
        }
    }

    /**
     * @param UserUpdateCommand $command
     */
    public function userUpdate(UserUpdateCommand $command)
    {
        /** @var User $user */
        $user = $this->repository->find($command->userDTO->getId());
        $user->setActive($command->userDTO->isActive());
        $this->repository->save($user);
    }

    /**
     * @param SuccessfulRegistrationCommand $command
     */
    public function successfulRegistration(SuccessfulRegistrationCommand $command)
    {
        $mail = \Swift_Message::newInstance()
            ->setSubject('Aulinks user activation')
            ->setFrom('robot@aulinks.com')
            ->setTo($command->email)
            ->setBody(
                sprintf('<div>Congratulation<br> User "%s" was successful created!</div>', $command->username),
                'text/html');
        $this->mailer->send($mail);
    }
}