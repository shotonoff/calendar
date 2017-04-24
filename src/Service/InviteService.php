<?php declare(strict_types = 1);

namespace Aulinks\Service;

use Tuupola\Base62;

/**
 * Class InviteService
 * @package Aulinks\Service
 */
class InviteService
{
    /** @var Base62 */
    private $crypt;

    /**
     * InviteService constructor.
     * @param Base62 $crypt
     */
    public function __construct(Base62 $crypt)
    {
        $this->crypt = $crypt;
    }

    /**
     * @param InviteTokenSubjectInterface $subject
     * @return string
     */
    public function createInviteToken(InviteTokenSubjectInterface $subject): string
    {
        return $this->encode([
            'id' => $subject->getId(),
            'email' => $subject->getEmail(),
            'expired' => $subject->getExpired()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param array|\JsonSerializable $data
     * @return string
     * @throws \Exception
     */
    public function encode($data): string
    {
        if(!is_array($data) && !$data instanceof \JsonSerializable) {
            throw new \Exception('Incompatible type');
        }
        return $this->crypt->encode(json_encode($data));
    }

    /**
     * @param string $token
     * @return array
     */
    public function decode(string $token): array
    {
        return json_decode($this->crypt->decode($token), true);
    }
}