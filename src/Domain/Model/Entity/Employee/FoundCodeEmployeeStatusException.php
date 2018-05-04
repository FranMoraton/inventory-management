<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class FoundCodeEmployeeStatusException extends \Exception
{
    public function __construct()
    {
        $message = 'El código de trabajador introducido ya existe';
        parent::__construct($message);
    }
}
