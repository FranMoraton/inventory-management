<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundCodeEmployeeStatusException extends \Exception
{
    public function __construct()
    {
        $message = 'El código de trabajador introducido ya existe';
        $code = 409;
        parent::__construct($message, $code);
    }
}
