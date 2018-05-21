<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class NotFoundPasswordEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'La contraseña introducida no es correcta';
        $code = HttpResponses::NOT_FOUND;
        parent::__construct($message, $code);
    }
}
