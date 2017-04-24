<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class UserCreateCommand
 * @package Aulinks\CRQS
 */
class UserCreateCommand extends DefaultCommand
{
    /** @var string|array */
    public $data;

    /** @var bool */
    public $inviteCheckSkip = false;
}