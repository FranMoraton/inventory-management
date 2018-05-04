<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

class FoundNameDepartmentException extends \Exception
{
    public function __construct()
    {
        $message = 'El departamento ya existe';
        parent::__construct($message);
    }
}
