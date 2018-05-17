<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class NotFoundEmployeesException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha encontrado ningún trabajador';
        $code = 404;
        parent::__construct($message, $code);
    }
}
