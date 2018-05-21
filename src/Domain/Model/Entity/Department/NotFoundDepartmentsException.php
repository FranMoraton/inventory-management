<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class NotFoundDepartmentsException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha encontrado ningún departamento';
        $code = HttpResponses::NOT_FOUND;
        parent::__construct($message, $code);
    }
}
