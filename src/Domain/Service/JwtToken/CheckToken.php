<?php

namespace Inventory\Management\Domain\Service\JwtToken;

use Inventory\Management\Domain\Model\JwtToken\JwtTokenClassInterface;

class CheckToken
{
    private $jwtTokenClass;

    public function __construct(JwtTokenClassInterface $jwtTokenClass)
    {
        $this->jwtTokenClass = $jwtTokenClass;
    }
    
    public function execute(string $role)
    {
        $data = $this->jwtTokenClass->checkToken($role);

        return $data;
    }
}
