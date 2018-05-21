<?php

namespace Inventory\Management\Domain\Model\JwtToken;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class InvalidUserTokenException extends \Exception
{
    public function __construct()
    {
        $message = 'El usuario al que intentas acceder no es tuyo';
        $code = HttpResponses::UNAUTHORIZED;
        parent::__construct($message, $code);
    }
}
