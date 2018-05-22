<?php

namespace Inventory\Management\Domain\Service\JwtToken;

use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;

class CheckToken
{
    private $jwtTokenClass;

    public function __construct(JwtTokenClass $jwtTokenClass)
    {
        $this->jwtTokenClass = $jwtTokenClass;
    }

    /**
     * @param string $role
     * @return mixed
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidRoleTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException
     */
    public function execute(string $role)
    {
        $data = $this->jwtTokenClass->checkToken($role);

        return $data;
    }
}
