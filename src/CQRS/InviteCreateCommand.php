<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\InviteRequestDTO;
use LiteCQRS\DefaultCommand;

/**
 * Class InviteCreateCommand
 * @package Aulinks\CQRS
 */
class InviteCreateCommand extends DefaultCommand
{
    /** @var InviteRequestDTO array */
    public $inviteDTO;
}