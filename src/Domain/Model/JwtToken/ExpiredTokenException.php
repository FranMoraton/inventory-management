<?php

namespace Inventory\Management\Domain\Model\JwtToken;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class ExpiredTokenException extends \Exception
{
    public function __construct()
    {
        $message = 'La sesión ha caducado';
        $code = HttpResponses::UNAUTHORIZED;
        parent::__construct($message, $code);
    }
}
