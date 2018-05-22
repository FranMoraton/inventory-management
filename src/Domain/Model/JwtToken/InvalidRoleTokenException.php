<?php

namespace Inventory\Management\Domain\Model\JwtToken;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class InvalidRoleTokenException extends \Exception
{
    public function __construct()
    {
        $message = 'No puedes acceder a esta información';
        $code = HttpResponses::UNAUTHORIZED;
        parent::__construct($message, $code);
    }
}
