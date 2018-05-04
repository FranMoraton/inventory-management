<?php

namespace Inventory\Management\Application\Department\UpdateNameSubDepartment;

use Assert\Assertion;

class UpdateNameSubDepartmentCommand
{
    private $subDepartment;
    private $name;

    public function __construct($subDepartment, $name)
    {
        Assertion::notBlank($subDepartment);
        Assertion::numeric($subDepartment);
        Assertion::notBlank($name);
        Assertion::string($name);

        $this->subDepartment = $subDepartment;
        $this->name = $name;
    }

    public function subDepartment(): int
    {
        return $this->subDepartment;
    }

    public function name(): string
    {
        return $this->name;
    }
}
