<?php declare(strict_types = 1);

namespace Aulinks\Service;

/**
 * Interface InviteTokenSubjectInterface
 * @package Aulinks\Service
 */
interface InviteTokenSubjectInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return \DateTimeInterface
     */
    public function getExpired(): \DateTimeInterface;
}