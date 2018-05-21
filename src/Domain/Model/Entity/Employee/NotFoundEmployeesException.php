<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class NotFoundEmployeesException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha encontrado ningún trabajador';
        $code = HttpResponses::NOT_FOUND;
        parent::__construct($message, $code);
    }
}
