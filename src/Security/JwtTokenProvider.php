<?php declare(strict_types = 1);

namespace Aulinks\Security;

use Firebase\JWT\JWT;
use Tuupola\Base62;

/**
 * Class JwtTokenProvider
 * @package Aulinks\Security
 */
class JwtTokenProvider
{
    /**
     * @param array $options
     * @return array
     */
    public function encode(array $options)
    {
        $now = new \DateTime();
        $future = new \DateTime("now +2 hours");
        $jti = (new Base62())->encode(random_bytes(16));
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            "sub" => $options['username'],
            "scope" => $options['scope']
        ];
        $secret = getenv("JWT_SECRET");
        $token = JWT::encode($payload, $secret, "HS256");
        return [
            'token' => $token,
            'expired' => $future->getTimestamp(),
        ];
    }
}