<?php

namespace Inventory\Management\Application\Util\Role;

use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class RoleEmployee
{
    private $checkToken;

    public function __construct(CheckToken $checkToken)
    {
        $this->checkToken = $checkToken;
    }

    /**
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidRoleTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException
     */
    public function checkToken()
    {
        return $this->checkToken->execute($this->role());
    }

    private function role(): string
    {
        return Roles::ROLE_EMPLOYEE;
    }
}
