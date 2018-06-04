<?php

namespace Inventory\Management\Application\RequestEmployee\ChangeStatusToDeletedRequest;

class ChangeStatusToDeletedRequestCommand
{
    private $employee;
    private $id;
    
    public function __construct($employee, $id)
    {
        $this->employee = $employee;
        $this->id = $id;
    }

    public function employee(): string
    {
        return $this->employee;
    }

    public function id(): int
    {
        return $this->id;
    }
}