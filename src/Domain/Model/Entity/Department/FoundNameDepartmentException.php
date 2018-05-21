<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class FoundNameDepartmentException extends \Exception
{
    public function __construct()
    {
        $message = 'El departamento ya existe';
        $code = HttpResponses::CONFLICT_SEARCH;
        parent::__construct($message, $code);
    }
}
