<?php

namespace Inventory\Management\Domain\Model\JwtToken;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class InvalidTokenException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha iniciado una sesión';
        $code = HttpResponses::NOT_FOUND;
        parent::__construct($message, $code);
    }
}
