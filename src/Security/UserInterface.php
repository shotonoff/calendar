<?php declare(strict_types = 1);

namespace Aulinks\Security;

/**
 * Interface UserInterface
 * @package Aulinks\Security
 */
interface UserInterface
{
    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return array
     */
    public function getRoles(): array;
}