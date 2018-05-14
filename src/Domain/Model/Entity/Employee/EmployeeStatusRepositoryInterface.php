<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

interface EmployeeStatusRepositoryInterface
{
    public function createEmployeeStatus(EmployeeStatus $employeeStatus): EmployeeStatus;
    public function checkNotExistsCodeEmployeeStatus(string $codeEmployee): ?EmployeeStatus;
}
