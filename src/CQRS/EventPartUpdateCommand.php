<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class EventPatchCommand
 * @package Aulinks\CQRS
 */
class EventPartUpdateCommand extends DefaultCommand
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string|array
     */
    public $data;
}