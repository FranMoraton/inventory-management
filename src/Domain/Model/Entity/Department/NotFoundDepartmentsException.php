<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

class NotFoundDepartmentsException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha encontrado ningún departamento';
        parent::__construct($message);
    }
}