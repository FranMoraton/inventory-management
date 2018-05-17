<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundTelephoneEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El teléfono introducido ya existe';
        $code = 409;
        parent::__construct($message, $code);
    }
}
