<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

class FoundNameSubDepartmentException extends \Exception
{
    public function __construct()
    {
        $message = 'El subdepartamento ya existe';
        $code = 409;
        parent::__construct($message, $code);
    }
}
