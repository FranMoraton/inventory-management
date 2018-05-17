<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

class FoundNameDepartmentException extends \Exception
{
    public function __construct()
    {
        $message = 'El departamento ya existe';
        $code = 409;
        parent::__construct($message, $code);
    }
}
