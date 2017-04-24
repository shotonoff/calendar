<?php declare(strict_types = 1);

namespace Aulinks\Entity;

use Aulinks\Service\InviteTokenSubjectInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="\Aulinks\Repository\InviteRepository")
 * @ORM\Table(name="invites")
 * @ORM\HasLifecycleCallbacks
 *
 * Class Invite
 * @package Aulinks\Entity
 */
class Invite extends EntityAbstract implements InviteTokenSubjectInterface
{
    /**
     * @ORM\Column(name="email", type="string", length=128)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="expired", type="datetime")
     * @var \DateTimeInterface
     */
    private $expired;

    /**
     * @ORM\Column(name="token", type="text")
     * @var string
     */
    private $token = '';

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="\Aulinks\Entity\User", mappedBy="invite")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="active", type="boolean")
     * @var bool
     */
    private $active = false;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getExpired(): \DateTimeInterface
    {
        return $this->expired;
    }

    /**
     * @param \DateTimeInterface $expired
     */
    public function setExpired(\DateTimeInterface $expired)
    {
        $this->expired = $expired;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistCallback()
    {
        if ($this->isNew()) {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
    }
}