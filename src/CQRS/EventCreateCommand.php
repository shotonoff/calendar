<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use Aulinks\DTO\EventDTO;
use LiteCQRS\DefaultCommand;

/**
 * Class EventCreateCommand
 * @package Aulinks\CRQS
 */
class EventCreateCommand extends DefaultCommand
{
    /** @var EventDTO */
    public $eventDTO;
}