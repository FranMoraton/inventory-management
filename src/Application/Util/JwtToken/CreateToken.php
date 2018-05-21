<?php

namespace Inventory\Management\Application\Util\JwtToken;

use Inventory\Management\Infrastructure\Util\JwtToken\JwtTokenUtil;

class CreateToken
{
    private $jwtTokenUtil;

    public function __construct(JwtTokenUtil $jwtTokenUtil)
    {
        $this->jwtTokenUtil = $jwtTokenUtil;
    }

    public function handle(array $data): string
    {
        $token = $this->jwtTokenUtil->createToken($data);

        return $token;
    }
}
