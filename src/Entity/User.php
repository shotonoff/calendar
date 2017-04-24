<?php declare(strict_types = 1);

namespace Aulinks\Entity;

use Aulinks\Security\UserInterface;
use Aulinks\Service\InviteTokenSubjectInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Aulinks\Repository\UserRepository")
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="name_idx", columns={"username"})})
 * @ORM\HasLifecycleCallbacks
 *
 * Class User
 * @package Aulinks\Entity
 */
class User extends EntityAbstract implements UserInterface
{
    const ADMIN_ROLE = 1;
    const NORMAL_ROLE = 2;

    /**
     * @ORM\Column(name="username", type="string", length=128)
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(name="roles", type="json_array", length=255)
     * @var array
     */
    private $roles = [];

    /**
     * @ORM\Column(name="active", type="boolean")
     * @var bool
     */
    private $active = false;

    /**
     * @ORM\OneToMany(targetEntity="\Aulinks\Entity\Event", mappedBy="user")
     * @var ArrayCollection
     */
    private $events;

    /**
     * @ORM\OneToOne(targetEntity="\Aulinks\Entity\Invite", mappedBy="user")
     * @var Invite|null
     */
    private $invite;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
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

    /**
     * @param int $role
     */
    public function addRole(int $role)
    {
        if (in_array($role, $this->roles)) {
            return;
        }
        $this->roles[] = $role;
    }

    /**
     * @param int $role
     * @return bool
     */
    public function hasRole(int $role): bool
    {
        return in_array($role, $this->roles);
    }

    /**
     * @param Event $event
     */
    public function addEvent(Event $event)
    {
        if ($this->events->contains($event)) {
            return;
        }
        $this->events->add($event);
    }

    /**
     * @return Invite|null
     */
    public function getInvite()
    {
        return $this->invite;
    }

    /**
     * @param Invite $invite
     */
    public function setInvite(Invite $invite)
    {
        $this->invite = $invite;
        $invite->setUser($this);
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
     * @ORM\PrePersist
     */
    public function prePersistCallback()
    {
        if ($this->isNew()) {
            $this->createdAt = new \DateTime();
        }
    }
}