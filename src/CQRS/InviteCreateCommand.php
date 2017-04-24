<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class InviteCreateCommand
 * @package Aulinks\CQRS
 */
class InviteCreateCommand extends DefaultCommand
{
    /** @var string|array */
    public $data;
}