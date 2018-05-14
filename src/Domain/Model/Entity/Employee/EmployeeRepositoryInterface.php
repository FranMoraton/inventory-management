<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee\UpdateBasicFieldsEmployeeCommand;
use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatusCommand;

interface EmployeeRepositoryInterface
{
    public function createEmployee(Employee $employee): Employee;
    public function changeStatusToDisableEmployee(Employee $employee): Employee;
    public function changeStatusToEnableEmployee(Employee $employee): Employee;
    public function updateBasicFieldsEmployee(
        Employee $employee,
        string $passwordHash,
        UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand
    ): Employee;
    public function updateFieldsEmployeeStatus(
        Employee $employee,
        string $image,
        UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand
    ): Employee;
    public function findEmployeeByNif(string $nif): ?Employee;
    public function showByFirstResultEmployees(int $initialResult): array;
    public function checkNotExistsNifEmployee(string $nif): ?Employee;
    public function checkNotExistsInSsNumberEmployee(string $inSsNumber): ?Employee;
    public function checkNotExistsTelephoneEmployee(string $telephone): ?Employee;
}
