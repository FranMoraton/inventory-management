<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundNifEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El NIF introducido ya existe';
        $code = 409;
        parent::__construct($message, $code);
    }
}
