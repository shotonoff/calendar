<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class UserSendInviteCommand
 * @package Aulinks\CQRS
 */
class InviteSendCommand extends DefaultCommand
{
    /** @var string */
    public $email;

    /** @var string */
    public $token;
}