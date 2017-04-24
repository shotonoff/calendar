<?php declare(strict_types = 1);

namespace Aulinks\Security;

/**
 * Class PasswordHandler
 * @package Aulinks\Security
 */
class PasswordHandler
{
    /** @var int */
    private $algo = PASSWORD_DEFAULT;

    /** @var int */
    private $cost = 12;

    /**
     * @param string $password
     * @param array $options
     * @return string
     */
    public function hash(string $password, array $options = []): string
    {
        if (!array_key_exists('cost', $options)) {
            $options['cost'] = $this->cost;
        }
        if (!array_key_exists('salt', $options)) {
            $options['salt'] = $this->salt();
        }
        return password_hash($password, $this->algo, $options);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * @param string $salt
     * @return string
     */
    public function salt(string $salt = ''): string
    {
        return sha1(time() . $salt . random_bytes(16));
    }
}