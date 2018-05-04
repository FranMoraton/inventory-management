<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

class NotFoundSubDepartmentsException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha encontrado ningún subdepartamento';
        parent::__construct($message);
    }
}
