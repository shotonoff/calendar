<?php declare(strict_types = 1);

namespace Aulinks\Repository\Specification;

use Aulinks\Specification\SpecificationInterface;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class UserInviteSpecification
 * @package Aulinks\Repository\Specification
 */
class UserInviteSpecification implements SpecificationInterface
{
    /** @var string */
    private $token;

    /**
     * UserInviteSpecification constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @param QueryBuilder $qb
     * @return bool
     */
    public function isSatisfiedBy($qb): bool
    {
        $now = new \DateTimeImmutable('now');
        $qb
            ->andWhere($qb->expr()->eq('u.inviteToken', ':inviteToken'))->setParameter('inviteToken', $this->token)
            ->andWhere($qb->expr()->lt('u.inviteExpired', ':inviteExpired'))->setParameter('inviteExpired', $now)
            ->andWhere($qb->expr()->eq('u.active', ':active'))->setParameter('active', false)
        ;
        return true;
    }
}