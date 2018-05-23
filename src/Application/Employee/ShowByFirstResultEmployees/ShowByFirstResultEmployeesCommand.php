<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Assert\Assertion;

class ShowByFirstResultEmployeesCommand
{
    private const MIN_POSITION = 0;
    private $firstResultPosition;
    private $name;
    private $code;
    private $department;
    private $subDepartment;

    public function __construct($firstResultPosition, $name, $code, $department, $subDepartment)
    {
        Assertion::min($firstResultPosition, self::MIN_POSITION);
        $this->firstResultPosition = $firstResultPosition;
        $this->name = $name;
        $this->code = $code;
        $this->department = $department;
        $this->subDepartment = $subDepartment;
    }

    public function firstResultPosition(): int
    {
        return $this->firstResultPosition;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function code(): ?int
    {
        return $this->code;
    }

    public function department(): ?int
    {
        return $this->department;
    }

    public function subDepartment(): ?int
    {
        return $this->subDepartment;
    }
}
