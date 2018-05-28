<?php

namespace Inventory\Management\Application\Util\Role;

use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class RoleAdmin
{
    private $dataToken;

    public function __construct(CheckToken $checkToken)
    {
        $this->dataToken = $checkToken->execute(
            $this->role()
        );
    }

    public function dataToken()
    {
        return $this->dataToken;
    }

    private function role(): string
    {
        return Roles::ROLE_ADMIN;
    }
}
