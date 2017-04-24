<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\UserRequestDTO;
use LiteCQRS\DefaultCommand;

/**
 * Class UserCreateCommand
 * @package Aulinks\CRQS
 */
class UserCreateCommand extends DefaultCommand
{
    /** @var UserRequestDTO */
    public $userDTO;

    /** @var bool */
    public $inviteCheckSkip = false;
}