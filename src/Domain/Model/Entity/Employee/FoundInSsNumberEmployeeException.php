<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class FoundInSsNumberEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El número de la seguridad social introducido ya existe';
        $code = HttpResponses::CONFLICT_SEARCH;
        parent::__construct($message, $code);
    }
}
