<?php

namespace Aulinks\CQRS;

use Aulinks\DTO\UserRequestDTO;
use Aulinks\Entity\Invite;
use Aulinks\Entity\User;
use Aulinks\Hydrator\UserHydrator;
use Aulinks\Repository\InviteRepository;
use Aulinks\Repository\UserRepository;
use Aulinks\Service\InviteService;
use JMS\Serializer\Serializer;
use \Mockery as m;

/**
 * Class UserServiceTest
 * @package Aulinks\CQRS
 */
class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @covers \Aulinks\CQRS\UserService::userCreate
     */
    public function testCreatingUserCommand()
    {
        $userDTO = new UserRequestDTO();
        $userDTO->setInviteToken('token');
        $invite = new Invite();
        $invite->setActive(false);

        $userRepo = m::mock(UserRepository::class)
            ->shouldReceive('save')->with(User::class)->twice()
            ->getMock();

        $inviteRepo = m::mock(InviteRepository::class)
            ->shouldReceive('find')->with(101)->andReturn($invite)
            ->getMock();
        $userHydr = m::mock(UserHydrator::class)
            ->shouldReceive('hydrate')->with(UserRequestDTO::class, User::class)->twice()
            ->andReturnUsing(function($_, User $user){
                $user->setEmail('email@aulinks.com');
                $user->setUsername('email@aulinks.com');
            })
            ->getMock();
        $inviteService = m::mock(InviteService::class)
            ->shouldReceive('decode')->with('token')->andReturn(['id' => 101, 'expired' => '2017-04-24 09:00:00'])
            ->getMock();
        $mailer = m::mock(\Swift_Mailer::class)
            ->shouldReceive('send')->with(\Swift_Message::class)->twice()
            ->getMock();

        $service = new UserService($userRepo, $inviteRepo, $userHydr, $inviteService, $mailer);
        $command = new UserCreateCommand([
            'data' => ['data'],
            'inviteCheckSkip' => false
        ]);
        $service->userCreate($command);
        $command->inviteCheckSkip = true;
        $service->userCreate($command);
    }
}