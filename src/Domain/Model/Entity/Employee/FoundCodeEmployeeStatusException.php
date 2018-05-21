<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class FoundCodeEmployeeStatusException extends \Exception
{
    public function __construct()
    {
        $message = 'El código de trabajador introducido ya existe';
        $code = HttpResponses::CONFLICT_SEARCH;
        parent::__construct($message, $code);
    }
}
