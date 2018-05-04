<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

class NotFoundPasswordEmployeeException extends \Exception
{
    public function __construct()
    {
        $message = 'La contraseña introducida no es correcta';
        parent::__construct($message);
    }
}
