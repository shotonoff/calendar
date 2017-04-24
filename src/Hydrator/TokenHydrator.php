<?php declare(strict_types = 1);

namespace Aulinks\Hydrator;

use Aulinks\Security\JwtToken;

/**
 * Class TokenHydrator
 * @package Aulinks\Hydrator
 */
class TokenHydrator implements HydratorInterface
{
    /**
     * @param mixed $data
     * @param null $dto
     */
    public function hydrate($data, $dto = null)
    {
        if (null === $dto) {
            $dto = new JwtToken();
        }
        $dto->setPermissions($data->scope->permissions);
//        $entity->setIat($data->iat);
//        $entity->setExp($data->exp);
//        $entity->setJti($data->jti);
//        $entity->setSub($data->sub);
    }
}