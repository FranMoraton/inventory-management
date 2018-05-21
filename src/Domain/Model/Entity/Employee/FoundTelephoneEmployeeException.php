<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class FoundTelephoneEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'El teléfono introducido ya existe';
        $code = HttpResponses::CONFLICT_SEARCH;
        parent::__construct($message, $code);
    }
}
