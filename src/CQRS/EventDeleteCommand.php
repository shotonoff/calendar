<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class EventDeleteCommand
 * @package Aulinks\CQRS
 */
class EventDeleteCommand extends DefaultCommand
{
    /** @var int */
    public $id;

    /** @var int */
    public $userId;
}