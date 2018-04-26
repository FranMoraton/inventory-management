<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Assert\Assertion;
use Inventory\Management\Domain\Model\Entity\Department\Department;

class CreateSubDepartmentCommand
{
    private $department;
    private $name;

    public function __construct($department, $name)
    {
        Assertion::notBlank($department, 'Tienes que especificar el id del departamento');
        Assertion::numeric($department, 'El id del departamento tiene que ser un número');
        Assertion::notBlank($name, 'Tienes que especificar el nombre del departamento');
        Assertion::string($name, 'El nombre tiene que ser de tipo texto');

        $this->department = $department;
        $this->name = $name;
    }

    public function department(): int
    {
        return $this->department;
    }

    public function name(): string
    {
        return $this->name;
    }
}
