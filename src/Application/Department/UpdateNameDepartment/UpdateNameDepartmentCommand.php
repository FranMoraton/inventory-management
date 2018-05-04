<?php

namespace Inventory\Management\Application\Department\UpdateNameDepartment;

use Assert\Assertion;

class UpdateNameDepartmentCommand
{
    private $department;
    private $name;

    public function __construct($department, $name)
    {
        Assertion::notBlank($department);
        Assertion::numeric($department);
        Assertion::notBlank($name);
        Assertion::string($name);

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
