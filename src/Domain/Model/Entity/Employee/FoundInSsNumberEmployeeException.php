<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundInSsNumberEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El número de la seguridad social introducido ya existe';
        $code = 409;
        parent::__construct($message, $code);
    }
}
