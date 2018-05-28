<?php

namespace Inventory\Management\Application\Util\Role;

use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class RoleAdmin
{
    private $checkToken;

    public function __construct(CheckToken $checkToken)
    {
        $this->checkToken = $checkToken;
    }

    public function checkToken()
    {
        return $this->checkToken->execute($this->role());
    }

    private function role(): string
    {
        return Roles::ROLE_ADMIN;
    }
}