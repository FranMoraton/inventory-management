<?php

namespace Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee;

class UpdateBasicFieldsEmployeeCommand
{
    private $nif;
    private $name;
    private $password;
    private $telephone;

    public function __construct($nif, $name, $password, $telephone)
    {
        $this->nif = $nif;
        $this->name = $name;
        $this->password = $password;
        $this->telephone = $telephone;
    }

    public function nif(): string
    {
        return $this->nif;
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
