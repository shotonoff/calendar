<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\EventDTO;
use LiteCQRS\DefaultCommand;

/**
 * Class EventPatchCommand
 * @package Aulinks\CQRS
 */
class EventPartUpdateCommand extends DefaultCommand
{
    /** @var int */
    public $id;

    /** @var int */
    public $userId;

    /** @var EventDTO */
    public $eventDTO;
}