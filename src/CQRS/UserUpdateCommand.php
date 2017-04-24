<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\UserRequestUpdateDTO;
use LiteCQRS\DefaultCommand;

/**
 * Class UserUpdateCommand
 * @package Aulinks\CRQS
 */
class UserUpdateCommand extends DefaultCommand
{
    /** @var UserRequestUpdateDTO */
    public $userDTO;
}