<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundNifEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El NIF introducido ya existe';
        parent::__construct($message);
    }
}
