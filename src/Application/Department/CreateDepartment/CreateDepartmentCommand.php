<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Assert\Assertion;

class CreateDepartmentCommand
{
    private $name;

    public function __construct($name)
    {
        Assertion::notBlank($name, 'Tienes que especificar el nombre del departamento');
        Assertion::string($name, 'El nombre del departamento tiene que ser de tipo texto');

        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
