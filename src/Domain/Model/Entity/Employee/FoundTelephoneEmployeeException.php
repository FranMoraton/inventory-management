<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundTelephoneEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El teléfono introducido ya existe';
        parent::__construct($message);
    }
}
