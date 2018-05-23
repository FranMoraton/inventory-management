<?php

namespace Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee;

class UpdateBasicFieldsEmployeeCommand
{
    private $name;
    private $password;
    private $telephone;

    public function __construct($name, $password, $telephone)
    {
        $this->name = $name;
        $this->password = $password;
        $this->telephone = $telephone;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function telephone(): string
    {
        return $this->telephone;
    }
}
